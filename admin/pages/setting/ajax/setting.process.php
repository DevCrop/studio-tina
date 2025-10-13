<?php

include_once "../../../../inc/lib/base.class.php";
include_once "../../../lib/admin.check.ajax.php";

$pdo = DB::getInstance();
$mode = $_POST['mode'];

if ($mode == "pwd.change") {

    $pwd_old = $_POST['pwd_old'];
    $pwd_new = $_POST['pwd_new'];
    $pwd_new_confirm = $_POST['pwd_new_confirm'];

    $hashed = hash("sha256", $pwd_old);

    $stmt = $pdo->prepare("SELECT a.no, a.uid, a.upwd, a.uname, a.active_status 
                           FROM nb_admin a 
                           WHERE a.sitekey = :sitekey");
    $stmt->execute(['sitekey' => $NO_SITE_UNIQUE_KEY]);
    $data = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$data) {
        echo json_encode(["result" => "fail", "msg" => "비정상적인 접근입니다."]);
        exit;
    } else {
        $db_no = $data['no'];
        $db_pwd = $data['upwd'];

        if ($db_pwd !== $hashed) {
            echo json_encode(["result" => "fail", "msg" => "현재 비밀번호가 일치하지 않습니다. 다시 입력해주세요"]);
            exit;
        }

        if ($pwd_new !== $pwd_new_confirm) {
            echo json_encode(["result" => "fail", "msg" => "변경하시려는 신규 비밀번호와 비밀번호 확인이 서로 일치하지 않습니다."]);
            exit;
        }

        $new_hashed = hash("sha256", $pwd_new);

        $stmt = $pdo->prepare("UPDATE nb_admin SET upwd = :new_pwd WHERE no = :no");
        $result = $stmt->execute(['new_pwd' => $new_hashed, 'no' => $db_no]);

        if ($result) {
            session_destroy();  

            echo json_encode(["result" => "success", "msg" => "정상적으로 수정 되었습니다. 변경된 비밀번호로 새로 로그인해주세요."]);
        } else {
            echo json_encode(["result" => "fail", "msg" => "비밀번호 변경에 실패했습니다. 다시 시도해주세요."]);
        }
    }

}


if ($mode == "setting.config.save") {

    // Default values for missing POST data
    $title = isset($_POST['title']) ? $_POST['title'] : '';
    $phone = isset($_POST['phone']) ? $_POST['phone'] : '';
    $hp = isset($_POST['hp']) ? $_POST['hp'] : '';
    $fax = isset($_POST['fax']) ? $_POST['fax'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $customercenter_able_time = isset($_POST['customercenter_able_time']) ? $_POST['customercenter_able_time'] : '';
    $company_able_time = isset($_POST['company_able_time']) ? $_POST['company_able_time'] : '';
    $google_map_key = isset($_POST['google_map_key']) ? $_POST['google_map_key'] : '';
    $footer_name = isset($_POST['footer_name']) ? $_POST['footer_name'] : '';
    $footer_address = isset($_POST['footer_address']) ? $_POST['footer_address'] : '';
    $footer_phone = isset($_POST['footer_phone']) ? $_POST['footer_phone'] : '';
    $footer_hp = isset($_POST['footer_hp']) ? $_POST['footer_hp'] : '';
    $footer_fax = isset($_POST['footer_fax']) ? $_POST['footer_fax'] : '';
    $footer_email = isset($_POST['footer_email']) ? $_POST['footer_email'] : '';
    $footer_owner = isset($_POST['footer_owner']) ? $_POST['footer_owner'] : '';
    $footer_ssn = isset($_POST['footer_ssn']) ? $_POST['footer_ssn'] : '';
    $footer_policy_charger = isset($_POST['footer_policy_charger']) ? $_POST['footer_policy_charger'] : '';
    $meta_keywords = isset($_POST['meta_keywords']) ? $_POST['meta_keywords'] : '';
    $meta_description = isset($_POST['meta_description']) ? $_POST['meta_description'] : '';

    // Handle file uploads with checks
    $logo_top_filename = isset($_POST['logo_top_filename']) ? $_POST['logo_top_filename'] : '';
    $logo_footer_filename = isset($_POST['logo_footer_filename']) ? $_POST['logo_footer_filename'] : '';
    $meta_thumb_filename = isset($_POST['meta_thumb_filename']) ? $_POST['meta_thumb_filename'] : '';
    $meta_favicon_ico_filename = isset($_POST['meta_favicon_ico_filename']) ? $_POST['meta_favicon_ico_filename'] : '';

    $dir_logo = $UPLOAD_SITEINFO_DIR_LOGO;
    $dir_meta = $UPLOAD_META_DIR;

    // Initialize $uploadResult to handle upload results
    $uploadResult = ['saved' => ''];

    // Handle logo and meta file uploads
    if (isset($_FILES['logo_top'])) {
        $uploadResult = imageUpload($dir_logo, $_FILES['logo_top'], $logo_top_filename, false);
        $logo_top = $uploadResult['saved'];
    }

    if (isset($_FILES['logo_footer'])) {
        $uploadResult = imageUpload($dir_logo, $_FILES['logo_footer'], $logo_footer_filename, false);
        $logo_footer = $uploadResult['saved'];
    }

    if (isset($_FILES['meta_thumb'])) {
        $uploadResult = imageUpload($dir_meta, $_FILES['meta_thumb'], $meta_thumb_filename, false);
        $meta_thumb = $uploadResult['saved'];
    }

    if (isset($_FILES['meta_favicon_ico'])) {
        $uploadResult = imageUpload($dir_meta, $_FILES['meta_favicon_ico'], $meta_favicon_ico_filename, false);
        $meta_favicon_ico = $uploadResult['saved'];
    }

    // Check if entry exists in the database
    $stmt = $pdo->prepare("SELECT a.no FROM nb_siteinfo a WHERE a.sitekey = :sitekey");
    $stmt->execute(['sitekey' => $NO_SITE_UNIQUE_KEY]);
    $data = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($data) {
        // Update existing record
        $query = "UPDATE nb_siteinfo SET 
                    title = :title,
                    phone = :phone,
                    hp = :hp,
                    fax = :fax,
                    email = :email,
                    customercenter_able_time = :customercenter_able_time,
                    company_able_time = :company_able_time,
                    google_map_key = :google_map_key,
                    footer_name = :footer_name,
                    footer_address = :footer_address,
                    footer_phone = :footer_phone,
                    footer_hp = :footer_hp,
                    footer_fax = :footer_fax,
                    footer_email = :footer_email,
                    footer_owner = :footer_owner,
                    footer_ssn = :footer_ssn,
                    footer_policy_charger = :footer_policy_charger,
                    meta_keywords = :meta_keywords,
                    meta_description = :meta_description";

        if ($logo_top) $query .= ", logo_top = :logo_top";
        if ($logo_footer) $query .= ", logo_footer = :logo_footer";
        if ($meta_thumb) $query .= ", meta_thumb = :meta_thumb";
        if ($meta_favicon_ico) $query .= ", meta_favicon_ico = :meta_favicon_ico";
        
        $query .= " WHERE sitekey = '$NO_SITE_UNIQUE_KEY'";

        $stmt = $pdo->prepare($query);
        $params = compact(
            'title', 'phone', 'hp', 'fax', 'email', 'customercenter_able_time', 
            'company_able_time', 'google_map_key', 'footer_name', 'footer_address', 
            'footer_phone', 'footer_hp', 'footer_fax', 'footer_email', 'footer_owner', 
            'footer_ssn', 'footer_policy_charger', 'meta_keywords', 'meta_description'
        );
        if ($logo_top) $params['logo_top'] = $logo_top;
        if ($logo_footer) $params['logo_footer'] = $logo_footer;
        if ($meta_thumb) $params['meta_thumb'] = $meta_thumb;
        if ($meta_favicon_ico) $params['meta_favicon_ico'] = $meta_favicon_ico;

        $result = $stmt->execute($params);

        echo json_encode(["result" => $result ? "success" : "fail", "msg" => $result ? "정상적으로 수정되었습니다." : "처리중 문제가 발생하였습니다.[Error-DB]"]);

    } else {
        // Insert new record
        $query = "INSERT INTO nb_siteinfo (
                    sitekey, title, logo_top, logo_footer, meta_thumb, meta_favicon_ico, 
                    phone, hp, fax, email, customercenter_able_time, company_able_time, 
                    google_map_key, footer_name, footer_address, footer_phone, footer_hp, 
                    footer_fax, footer_email, footer_owner, footer_ssn, footer_policy_charger, 
                    meta_keywords, meta_description
                  ) VALUES (
                    '$NO_SITE_UNIQUE_KEY', :title, :logo_top, :logo_footer, :meta_thumb, :meta_favicon_ico, 
                    :phone, :hp, :fax, :email, :customercenter_able_time, :company_able_time, 
                    :google_map_key, :footer_name, :footer_address, :footer_phone, :footer_hp, 
                    :footer_fax, :footer_email, :footer_owner, :footer_ssn, :footer_policy_charger, 
                    :meta_keywords, :meta_description
                  )";

        $stmt = $pdo->prepare($query);
        $params = compact(
            'title', 'logo_top', 'logo_footer', 'meta_thumb', 
            'meta_favicon_ico', 'phone', 'hp', 'fax', 'email', 'customercenter_able_time', 
            'company_able_time', 'google_map_key', 'footer_name', 'footer_address', 
            'footer_phone', 'footer_hp', 'footer_fax', 'footer_email', 'footer_owner', 
            'footer_ssn', 'footer_policy_charger', 'meta_keywords', 'meta_description'
        );

        $result = $stmt->execute($params);
        echo json_encode(["result" => $result ? "success" : "fail", "msg" => $result ? "정상적으로 등록 되었습니다." : "처리중 문제가 발생하였습니다.[Error-DB]"]);
    }
}

?>