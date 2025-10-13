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
    $r->get('/about/company', fn() => render('pages.about.company'))->name('about.company');
    $r->get('/about/history', fn() => render('pages.about.history'))->name('about.history');
    $r->get('/about/partners', fn() => render('pages.about.partners'))->name('about.partners');

    // ========== News ==========
    $r->get('/news', function()  {
        $boardNo = 25;
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
    $r->get('/news/show/{no}', function(Request $req, Response $res, string $no) {
        $boardNo = 25;

        // no 값 검증
        if (!is_numeric($no)) {
            return $res->redirect('/news', 302);
        }

        // 뉴스 전용 상세 페이지
        return render('pages.news.show', [
            'no'        => (int)$no,
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