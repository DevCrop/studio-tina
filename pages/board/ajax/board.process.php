<?php

include_once "../../../inc/lib/base.class.php";
$connect = DB::getInstance();



$mode = $_POST['mode'] ?? '';

if ($mode === "board.password.confirm") {

    $no       = (int)($_POST['no'] ?? 0);
    $board_no = (int)($_POST['board_no'] ?? 0);
    $pwd      = $_POST['pwd'] ?? '';
    $hashed   = hash("sha256", $pwd);
    try {
        $pdo = DB::getInstance();

        $sql = "SELECT a.no, a.board_no, a.secret_pwd
                  FROM nb_board a
                 WHERE a.no = :no
                   AND a.secret_pwd = :hashed";

        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':no', $no, PDO::PARAM_INT);
        $stmt->bindValue(':hashed', $hashed, PDO::PARAM_STR);
        $stmt->execute();

        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if (!$data) {
            echo json_encode([
                "result" => "fail",
                "msg"    => "비밀번호가 일치하지 않습니다."
            ]);
            exit;
        } else {
            $_SESSION['board_secret_confirmed_' . $no] = "Y";
            echo json_encode([
                "result" => "success",
                "msg"    => "정상적으로 확인되었습니다."
            ]);
            exit;
        }

    } catch (Throwable $e) {
        echo json_encode([
            "result" => "fail",
            "msg"    => "처리 중 오류가 발생했습니다."
        ]);
        exit;
    }
}


elseif ($mode === 'board.delete') {
    $no       = (int)($_POST['no'] ?? 0);
    $board_no = (int)($_POST['board_no'] ?? 0);

    if ($no <= 0 || $board_no <= 0) {
        echo json_encode(["result"=>"fail","msg"=>"잘못된 요청입니다."]); exit;
    }

    try {
        $pdo = DB::getInstance();

        // 1) 글 존재 여부 확인
        $q = $pdo->prepare("
            SELECT no, board_no, is_secret
              FROM nb_board
             WHERE no = :no
               AND board_no = :board_no
               AND sitekey = :sitekey
             LIMIT 1
        ");
        $q->bindValue(':no',       $no, PDO::PARAM_INT);
        $q->bindValue(':board_no', $board_no, PDO::PARAM_INT);
        $q->bindValue(':sitekey',  $NO_SITE_UNIQUE_KEY, PDO::PARAM_STR);
        $q->execute();
        $row = $q->fetch(PDO::FETCH_ASSOC);

        if (!$row) {
            echo json_encode(["result"=>"fail","msg"=>"게시물을 찾을 수 없습니다."]); exit;
        }

        // 2) 비밀글이면 비밀번호 확인 세션 체크
        $sessKey = 'board_secret_confirmed_' . $no;
        if (($row['is_secret'] ?? 'N') === 'Y') {
            if (($_SESSION[$sessKey] ?? '') !== 'Y') {
                echo json_encode(["result"=>"fail","msg"=>"비밀번호 확인 후 다시 시도해주세요."]); exit;
            }
        }

        // 3) 삭제 (댓글 → 본문). 필요 시 첨부 테이블도 여기서 처리
        $pdo->beginTransaction();

        // 3-1) 댓글 삭제
        $delC = $pdo->prepare("
            DELETE FROM nb_board_comment
             WHERE parent_no = :no
               AND sitekey   = :sitekey
        ");
        $delC->bindValue(':no', $no, PDO::PARAM_INT);
        $delC->bindValue(':sitekey', $NO_SITE_UNIQUE_KEY, PDO::PARAM_STR);
        $delC->execute();

        // 3-2) 본문 삭제
        $delB = $pdo->prepare("
            DELETE FROM nb_board
             WHERE no = :no
               AND board_no = :board_no
               AND sitekey  = :sitekey
             LIMIT 1
        ");
        $delB->bindValue(':no',       $no, PDO::PARAM_INT);
        $delB->bindValue(':board_no', $board_no, PDO::PARAM_INT);
        $delB->bindValue(':sitekey',  $NO_SITE_UNIQUE_KEY, PDO::PARAM_STR);
        $delB->execute();

        if ($delB->rowCount() < 1) {
            $pdo->rollBack();
            echo json_encode(["result"=>"fail","msg"=>"삭제 중 문제가 발생했습니다."]); exit;
        }

        $pdo->commit();

        if (isset($_SESSION[$sessKey])) {
            unset($_SESSION[$sessKey]);
        }

        echo json_encode(["result"=>"success","msg"=>"정상적으로 삭제되었습니다."]); exit;

    } catch (Throwable $e) {
        if ($pdo && $pdo->inTransaction()) {
            $pdo->rollBack();
        }
        echo json_encode(["result"=>"fail","msg"=>"처리중 오류가 발생했습니다."]); exit;
    }
}



elseif ($mode === 'board.write') {
    $board_no   = (int)($_POST['board_no'] ?? 0);
    $title      = xss_clean($_POST['title'] ?? '');
    $write_name = xss_clean($_POST['write_name'] ?? '');
    $contents   = xss_clean($_POST['contents'] ?? '');
    $r_captcha  = xss_clean($_POST['r_captcha'] ?? '');
    $is_secret  = (($_POST['is_secret'] ?? 'N') === 'Y') ? 'Y' : 'N';
    $secret_pwd = $_POST['secret_pwd'] ?? '';

    if (!$board_no || $title === '' || $write_name === '' || $contents === '') {
        echo json_encode(["result"=>"fail","msg"=>"필수 항목이 누락되었습니다."]); exit;
    }
    if (!isset($_SESSION['captcha_secure']) || $_SESSION['captcha_secure'] != $r_captcha) {
        echo json_encode(["result"=>"fail","msg"=>"보안코드가 일치하지 않습니다. 정확히 입력해주세요"]); exit;
    }
    if ($is_secret === 'Y' && $secret_pwd === '') {
        echo json_encode(["result"=>"fail","msg"=>"비밀글 비밀번호를 입력해주세요"]); exit;
    }

    $hashed = ($is_secret === 'Y') ? hash('sha256', $secret_pwd) : null;
    $is_notice = 'N'; // 기본값

    try {
        $pdo = DB::getInstance(); 

        $sql = "INSERT INTO nb_board
                    (sitekey, board_no, user_no, title, contents, regdate, is_notice, is_secret, write_name, secret_pwd)
                VALUES
                    (:sitekey, :board_no, :user_no, :title, :contents, NOW(), :is_notice, :is_secret, :write_name, :secret_pwd)";

        $stmt = $pdo->prepare($sql);

        // 명시적 타입 바인딩(가독성 + 안전성)
        $stmt->bindValue(':sitekey',   $NO_SITE_UNIQUE_KEY, PDO::PARAM_STR);
        $stmt->bindValue(':board_no',  $board_no,           PDO::PARAM_INT);
        $stmt->bindValue(':user_no',   $NO_USR_NO,          PDO::PARAM_INT);
        $stmt->bindValue(':title',     $title,              PDO::PARAM_STR);
        $stmt->bindValue(':contents',  $contents,           PDO::PARAM_STR);
        $stmt->bindValue(':is_notice', $is_notice,          PDO::PARAM_STR);
        $stmt->bindValue(':is_secret', $is_secret,          PDO::PARAM_STR);
        $stmt->bindValue(':write_name',$write_name,         PDO::PARAM_STR);

        // 비밀글이 아니면 NULL 저장
        if ($hashed === null) {
            $stmt->bindValue(':secret_pwd', null, PDO::PARAM_NULL);
        } else {
            $stmt->bindValue(':secret_pwd', $hashed, PDO::PARAM_STR);
        }
        $ok = $stmt->execute();

        if ($ok) {
            echo json_encode(["result"=>"success","msg"=>"정상적으로 등록되었습니다."]);
        } else {
            echo json_encode(["result"=>"fail","msg"=>"처리중 문제가 발생하였습니다.[Error-DB]"]);
        }
    } catch (Throwable $e) {
        echo json_encode(["result"=>"fail","msg"=>"처리중 오류가 발생했습니다."]);
    }
}

elseif ($mode === "board.edit") {

    $no         = (int)($_POST['no'] ?? 0);
    $board_no   = (int)($_POST['board_no'] ?? 0);
    $title      = xss_clean($_POST['title'] ?? '');
    $write_name = xss_clean($_POST['write_name'] ?? '');
    $contents   = xss_clean($_POST['contents'] ?? '');
    $r_captcha  = xss_clean($_POST['r_captcha'] ?? '');

    if (!isset($_SESSION['captcha_secure']) || $_SESSION['captcha_secure'] != $r_captcha) {
        echo json_encode(["result"=>"fail","msg"=>"보안코드가 일치하지 않습니다. 정확히 입력해주세요"]); exit;
    }
    if (!$no || !$board_no || $title === '' || $write_name === '' || $contents === '') {
        echo json_encode(["result"=>"fail","msg"=>"필수 항목이 누락되었습니다."]); exit;
    }

    try {
        $pdo = DB::getInstance();

        $sql = "UPDATE nb_board
                   SET title = :title,
                       write_name = :write_name,
                       contents = :contents
                 WHERE no = :no
                   AND board_no = :board_no";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':title', $title, PDO::PARAM_STR);
        $stmt->bindValue(':write_name', $write_name, PDO::PARAM_STR);
        $stmt->bindValue(':contents', $contents, PDO::PARAM_STR);
        $stmt->bindValue(':no', $no, PDO::PARAM_INT);
        $stmt->bindValue(':board_no', $board_no, PDO::PARAM_INT);

        if ($stmt->execute()) {
            echo json_encode(["result"=>"success","msg"=>"정상적으로 수정되었습니다."]);
        } else {
            echo json_encode(["result"=>"fail","msg"=>"처리중 문제가 발생하였습니다.[Error-DB]"]);
        }
    } catch (Throwable $e) {
        echo json_encode(["result"=>"fail","msg"=>"처리 중 오류가 발생했습니다."]); 
    }
}


elseif ($mode === "board.delete.user") {

    $no       = (int)($_POST['no'] ?? 0);
    $board_no = (int)($_POST['board_no'] ?? 0);

    try {
        $pdo = DB::getInstance();

        // 글 존재/비밀글 여부 확인
        $sql = "SELECT a.no, a.board_no, a.is_secret
                  FROM nb_board a
                 WHERE a.no = :no";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':no', $no, PDO::PARAM_INT);
        $stmt->execute();
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$data) {
            echo json_encode(["result"=>"fail","msg"=>"비정상적인 접근입니다."]); exit;
        }

        if ($data['is_secret'] === "Y" && ($_SESSION['board_secret_confirmed_' . $no] ?? '') !== "Y") {
            echo json_encode(["result"=>"fail","msg"=>"비밀번호 확인이 필요한 게시물입니다."]); exit;
        }

        // 실제 삭제
        $sql = "DELETE FROM nb_board
                 WHERE no = :no
                   AND sitekey = :sitekey";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':no', $no, PDO::PARAM_INT);
        $stmt->bindValue(':sitekey', $NO_SITE_UNIQUE_KEY, PDO::PARAM_STR);
        // $stmt->bindValue(':board_no', $board_no, PDO::PARAM_INT);

        if ($stmt->execute()) {
            echo json_encode(["result"=>"success","msg"=>"정상적으로 삭제되었습니다."]);
        } else {
            echo json_encode(["result"=>"fail","msg"=>"처리중 문제가 발생하였습니다.[Error-DB]"]);
        }
    } catch (Throwable $e) {
        echo json_encode(["result"=>"fail","msg"=>"처리 중 오류가 발생했습니다."]);
    }
}

else if ($mode === "comment.save") {

    $no         = xss_clean($_POST['no'] ?? 0);
    $board_no   = xss_clean($_POST['board_no'] ?? 0); // 현재 쿼리에서는 사용하지 않지만 유지
    $write_name = xss_clean($_POST['write_name'] ?? '');
    $pwd        = xss_clean($_POST['pwd'] ?? '');
    $comment = xss_clean($_POST['comment_contents'] ?? '');


    $hashed = ($pwd !== '') ? hash("sha256", $pwd) : null;

    try {
        /** @var PDO $pdo */
        $pdo = DB::getInstance();

        $sql = "INSERT INTO nb_board_comment
                    (sitekey, parent_no, user_no, write_name, regdate, contents, pwd)
                VALUES
                    (:sitekey, :parent_no, :user_no, :write_name, NOW(), :contents, :pwd)";

        $stmt = $pdo->prepare($sql);

        // 명시적 바인딩
        $stmt->bindValue(':sitekey',   $NO_SITE_UNIQUE_KEY, PDO::PARAM_STR);
        $stmt->bindValue(':parent_no', (int)$no,            PDO::PARAM_INT);
        $stmt->bindValue(':user_no',   (int)$NO_USR_NO,     PDO::PARAM_INT);

        $stmt->bindValue(':write_name', $write_name, PDO::PARAM_STR);

        $stmt->bindValue(':contents',  $comment,            PDO::PARAM_STR);

        if ($hashed === null) {
            $stmt->bindValue(':pwd', null, PDO::PARAM_NULL);
        } else {
            $stmt->bindValue(':pwd', $hashed, PDO::PARAM_STR);
        }

        $ok = $stmt->execute();

        if ($ok) {
            echo json_encode(["result" => "success", "msg" => "정상적으로 등록되었습니다."]);
        } else {
            echo json_encode(["result" => "fail", "msg" => "처리중 문제가 발생하였습니다.[Error-DB]"]);
        }
        exit;

    } catch (Throwable $e) {
        echo json_encode(["result" => "fail", "msg" => "처리중 오류가 발생했습니다."]);
        exit;
    }
}


else if ($mode === "comment.delete") {
    $no = (int)($_POST['no'] ?? 0);

    if ($no <= 0) {
        echo json_encode(["result" => "fail", "msg" => "잘못된 요청입니다."]); exit;
    }

    try {
        $pdo = DB::getInstance();

        $del = $pdo->prepare(
            "DELETE FROM nb_board_comment
              WHERE no = :no AND sitekey = :sitekey
              LIMIT 1"
        );
        $del->bindValue(':no', $no, PDO::PARAM_INT);
        $del->bindValue(':sitekey', $NO_SITE_UNIQUE_KEY, PDO::PARAM_STR);
        $del->execute();

        if ($del->rowCount() > 0) {
            echo json_encode(["result" => "success", "msg" => "정상적으로 삭제되었습니다."]); exit;
        } else {
            echo json_encode(["result" => "fail", "msg" => "댓글을 찾을 수 없습니다."]); exit;
        }
    } catch (Throwable $e) {
        echo json_encode(["result" => "fail", "msg" => "처리중 오류가 발생했습니다."]); exit;
    }
}

?>