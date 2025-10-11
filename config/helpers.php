<?php 

use Core\Application;
use View\ViewEngine;
use Http\Response;

function app(): Application
{
    return Application::getInstance();
}


/**
 * 새 ViewEngine 인스턴스 생성 (라라벨의 view() 느낌)
 * - 반환값: ViewEngine (->setLayout()->render() 체이닝 가능)
 */
if (!function_exists('view')) {
    function view(string $template, array $data = [], ?string $viewsPath = null): ViewEngine
    {
        return new ViewEngine($template, $data, $viewsPath);
    }
}

/**
 * 바로 렌더링 결과 문자열만 받고 싶을 때
 */
if (!function_exists('render')) {
    function render(string $template, array $data = [], ?string $viewsPath = null): string
    {
        return view($template, $data, $viewsPath)->render();
    }
}

/**
 * 레이아웃 지정 (extend == setLayout)
 */
if (!function_exists('extend')) {
    function extend(string $layout): void
    {
        ViewEngine::getInstance()->setLayout($layout);
    }
}

/**
 * 섹션 시작/종료
 */
if (!function_exists('section')) {
    function section(string $name, $content = null): void
    {
        ViewEngine::getInstance()->section($name, $content !== null ? (string)$content : null);
    }
}

if (!function_exists('end_section')) {
    function end_section(): void
    {
        ViewEngine::getInstance()->endSection();
    }
}

/**
 * 레이아웃에서 섹션 출력
 * (yield는 예약어라 yield_section 으로)
 */
if (!function_exists('yield_section')) {
    function yield_section(string $name, string $default = ''): string
    {
        return ViewEngine::getInstance()->yield($name, $default);
    }
}

/**
 * 부분 뷰 포함 (include는 예약어 → view_include)
 */
if (!function_exists('include_view')) {
    function include_view(string $template, array $data = []): string
    {
        return ViewEngine::getInstance()->include($template, $data);
    }
}

/**
 * 전역 데이터 공유 (모든 렌더에서 사용 가능)
 */
if (!function_exists('share_view')) {
    function share_view(array $data): void
    {
        ViewEngine::getInstance()->mergeData($data);
    }
}

/**
 * 이스케이프 헬퍼 (라라벨의 e() 느낌)
 */
if (!function_exists('e')) {
    function e($v): string
    {
        return htmlspecialchars((string)$v, ENT_QUOTES, 'UTF-8', false);
    }
}


if (!function_exists('route')) {
    function route(string $name, array $params = [], bool $absolute = false): string {
        return Application::getInstance()->router()->route($name, $params, $absolute);
    }
}




if (!function_exists('response')) {
    /**
     * 텍스트 응답(Response 인스턴스 반환)
     */
    function response(string $content = '', int $status = 200, array $headers = []): Response
    {
        return new Response($content, $status, $headers);
    }
}

if (!function_exists('redirect')) {
    /**
     * URL로 리다이렉트 (Response 인스턴스 반환)
     *
     * 사용:
     *   return redirect('/news');
     */
    function redirect(string $url, int $status = 302): Response
    {
        return (new Response())->redirect($url, $status);
    }
}

if (!function_exists('redirect_route')) {
    /**
     * 라우트 네임으로 리다이렉트
     *
     * 사용:
     *   return redirect_route('company.news'); // 파라미터 있을 때: ['id' => 1]
     */
    function redirect_route(string $name, array $params = [], int $status = 302, bool $absolute = true): Response
    {
        $url = route($name, $params, $absolute);
        return redirect($url, $status);
    }
}

if (!function_exists('back')) {
    /**
     * 이전 페이지로 리다이렉트 (HTTP_REFERER 우선, 없으면 기본값)
     */
    function back(string $fallback = '/', int $status = 302): Response
    {
        $referer = $_SERVER['HTTP_REFERER'] ?? null;
        return redirect($referer ?: $fallback, $status);
    }
}