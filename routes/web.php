<?php

use Database\DB;
use Http\Request;
use Http\Response;

/**
 * @var \Routing\Router $router
 */
$router = app()->router();

// 홈/기본
$router->get('/', fn() => render('pages.index'));

$router->group(['prefix' => '/'], function ($r)  {

    // 기본 페이지
    $r->get('/', fn() => render('pages.index'))->name('home');
    $r->get('/contact', fn() => render('pages.company.contact'))->name('contact');

    // Company - About
    $r->get('/about', fn() => render('pages.company.about'))->name('company.about');

    // ========== Blog ==========
    $r->get('/blog', function()  {
        // ko: 8, en: 12
        $boardNo = app()->getLocale() === 'en' ? 12 : 8;

        $req = app()->request(); 
        $data = DB::fetchBoardList([
            'board_no'   => $boardNo,
            'category_no'=> (int)$req->query('category_no', 0) ?: null,
            'page'       => (int)$req->query('page', 1),
            'perpage'    => (int)$req->query('perpage', 0) ?: null,
            'search'     => [
                'keyword' => (string)$req->query('searchKeyword', ''),
                'column'  => (string)$req->query('searchColumn', ''),
                'sdate'   => (string)$req->query('sdate', ''),
                'edate'   => (string)$req->query('edate', ''),
            ],
        ]);
        return render('pages.blog.index', $data);
    })->name('blog.index');

    // BLOG 상세
    $r->get('/blog/{title}', function(Request $req, Response $res, string $title) {
        // 보드번호: ko=8, en=12
        $boardNo = app()->getLocale() === 'en' ? 12 : 8;

        $no = DB::findPostBySlug($boardNo, $title);
        if (!$no) {
            return $res->redirect('/' . app()->getLocale() . '/blog', 302);
        }


        $pdo = \DB::getInstance();
        $stmt = $pdo->prepare("SELECT a.*, c.name AS category_name
                            FROM nb_board a
                            LEFT JOIN nb_board_category c ON a.category_no = c.no
                            WHERE a.board_no = :bn AND a.no = :no");
        $stmt->execute([':bn' => $boardNo, ':no' => $no]);
        $post = $stmt->fetch(\PDO::FETCH_ASSOC);
        if (!$post) {
            return $res->redirect(route('blog.index'), 302);
        }

        $stmt = $pdo->prepare("SELECT no,title,regdate
                            FROM nb_board
                            WHERE board_no=:bn AND is_notice!='Y' AND no < :no
                            ORDER BY no DESC LIMIT 1");
        $stmt->execute([':bn'=>$boardNo, ':no'=>$no]);
        $prev = $stmt->fetch(\PDO::FETCH_ASSOC) ?: null;

        $stmt = $pdo->prepare("SELECT no,title,regdate
                            FROM nb_board
                            WHERE board_no=:bn AND is_notice!='Y' AND no > :no
                            ORDER BY no ASC LIMIT 1");
        $stmt->execute([':bn'=>$boardNo, ':no'=>$no]);
        $next = $stmt->fetch(\PDO::FETCH_ASSOC) ?: null;

        return render('pages.board.view', [
            'post'           => $post,
            'prev'           => $prev,
            'next'           => $next,
            'board_no'       => $boardNo,
            'listUrl'        => route('blog.index'),
            'showRouteName'  => 'blog.show',
        ]);
    })->name('blog.show');

    // ========== News ==========
    $r->get('/news', function()  {
        // ko: 9, en: 13
        $boardNo = app()->getLocale() === 'en' ? 13 : 9;
        $req = app()->request();

        $data = DB::fetchBoardList([
            'board_no'   => $boardNo,
            'category_no'=> (int)$req->query('category_no', 0) ?: null,
            'page'       => (int)$req->query('page', 1),
            'perpage'    => (int)$req->query('perpage', 0) ?: null,
            'search'     => [
                'keyword' => (string)$req->query('searchKeyword', ''),
                'column'  => (string)$req->query('searchColumn', ''),
                'sdate'   => (string)$req->query('sdate', ''),
                'edate'   => (string)$req->query('edate', ''),
            ],
        ]);
        return render('pages.news.index', $data);
    })->name('company.news');
    
    // NEWS 상세
    $r->get('/news/{title}', function(Request $req, Response $res, string $title) {
        $boardNo = app()->getLocale() === 'en' ? 13 : 9;

        $no = DB::findPostBySlug($boardNo, $title);
        if (!$no) {
            return $res->redirect('/' . app()->getLocale() . '/news', 302);
        }

        // 공통 view.php를 그대로 재사용
        return render('pages.board.view', [
            'no'        => $no,
            'board_no'  => $boardNo,
            'page'      => (int)$req->query('page', 1),
            'searchKeyword' => (string)$req->query('searchKeyword', ''),
            'searchColumn'  => (string)$req->query('searchColumn', ''),
        ]);
    })->name('company.news.show');

    
    // ========== Portfolio: Videos ==========
    $r->get('/portfolio/videos', function(Request $req, Response $res)  {
        // ko: 10, en: 14
        $boardNo = app()->getLocale() === 'en' ? 14 : 10;

        $data = DB::fetchBoardList([
            'board_no'   => $boardNo,
            'category_no'=> (int)$req->query('category_no', 0) ?: null,
            'page'       => (int)$req->query('page', 1),
            'perpage'    => (int)$req->query('perpage', 0) ?: null,
            'search'     => [
                'keyword' => (string)$req->query('searchKeyword', ''),
                'column'  => (string)$req->query('searchColumn', ''),
                'sdate'   => (string)$req->query('sdate', ''),
                'edate'   => (string)$req->query('edate', ''),
            ],
        ]);
        return render('pages.portfolio.videos', $data);
    })->name('portfolio.videos');

    // ========== Portfolio: Images ==========
    $r->get('/portfolio/images', function(Request $req, Response $res)  {
        // ko: 15, en: 16
        $boardNo = app()->getLocale() === 'en' ? 16 : 15;

        $data = DB::fetchBoardList([
            'board_no'   => $boardNo,
            'category_no'=> (int)$req->query('category_no', 0) ?: null,
            'page'       => (int)$req->query('page', 1),
            'perpage'    => (int)$req->query('perpage', 0) ?: null,
            'search'     => [
                'keyword' => (string)$req->query('searchKeyword', ''),
                'column'  => (string)$req->query('searchColumn', ''),
                'sdate'   => (string)$req->query('sdate', ''),
                'edate'   => (string)$req->query('edate', ''),
            ],
        ]);
        return render('pages.portfolio.images', $data);
    })->name('portfolio.images');

    // AI Platform
    $r->get('/ai_platform/ai', fn() => render('pages.platform.ai'))->name('platform.ai');
});