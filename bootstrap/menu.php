<?php

use Menu\Menu;

$menu = new Menu('site');
app()->share('menu', $menu);

/**
 * site_name: 스튜디오 티나
 * 최상위 섹션: ABOUT US, WORKS, NEWS, CONTACT
 */

// ABOUT US
$about = $menu->add('ABOUT US', '/about', 'about', ['orderIndex' => 10]);
$menu->add('COMPANY', '/about/company', 'company', ['parent' => $about, 'orderIndex' => 10]);
$menu->add('HISTORY', '/about/history', 'history', ['parent' => $about, 'orderIndex' => 20]);
$menu->add('PARTNERS', '/about/partners', 'partners', ['parent' => $about, 'orderIndex' => 30]);

// WORKS
$works = $menu->add('WORKS', '/works', 'works', ['orderIndex' => 20]);
$menu->add('PORTFOLIO', '/works/portfolio', 'portfolio', ['parent' => $works, 'orderIndex' => 10]);
$menu->add('CREATOR', '/works/creator', 'creator', ['parent' => $works, 'orderIndex' => 20]);

// NEWS
$news = $menu->add('NEWS', '/news', 'news', ['orderIndex' => 30]);
// JSON에서 title: "Palette AI", filename: "news" 이므로 목록/상세 진입점을 '/news'로 매핑
$menu->add('NEWS', '/news', 'news', ['parent' => $news, 'orderIndex' => 10]);

// CONTACT
$contact = $menu->add('CONTACT', '/contact', 'contact', ['orderIndex' => 40]);
$menu->add('contact', '/contact', 'contact-index', ['parent' => $contact, 'orderIndex' => 10]);