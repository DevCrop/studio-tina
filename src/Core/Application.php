<?php

namespace Core;

use Http\Request;
use Http\Response;
use Routing\Router;
use Throwable;

class Application 
{
    protected static ?Application $instance = null;
    protected Request $request;
    protected Response $response; 
    protected Router $router;  
    protected string $rootPath; 

    protected string $locale = DEFAULT_LOCALE;

    protected array $container = [];

    public function __construct(string $rootPath)
    {
        $this->rootPath = $rootPath; 
        $this->request  = new Request();
        $this->response = new Response(); 
        $this->router   = new Router(); 
    
        self::$instance = $this; 
    }

    /* ==================== Service Container ==================== */

    /**
     * 값을 공유(싱글톤)로 저장합니다.
     * 이미 인스턴스가 만들어진 객체나, 배열/스칼라 등 그대로 저장할 때 사용.
     */
    public function share(string $key, $value): void
    {
        $this->container[$key] = $value;
    }

    /**
     * key가 이미 있으면 덮어쓰지 않으려면 이걸로 체크.
     */
    public function has(string $key): bool
    {
        return array_key_exists($key, $this->container);
    }

    /**
     * 저장한 값을 조회합니다. (없으면 $default 반환)
     */
    public function get(string $key, $default = null)
    {
        return $this->container[$key] ?? $default;
    }

    /**
     * 항목 제거.
     */
    public function forget(string $key): void
    {
        unset($this->container[$key]);
    }

    /**
     * 필요하면 팩토리 바인딩도 지원 가능 (옵션)
     * $factory는 호출 시점에 인스턴스 생성. 1회 생성 후 share로 고정시키고 싶으면 $singleton=true.
     */
    public function bind(string $key, callable $factory, bool $singleton = false): void
    {
        if ($singleton) {
            $this->container[$key] = $factory($this);
            return;
        }
        $this->container[$key] = $factory; // lazy로 저장
    }

    /**
     * bind()로 저장한 팩토리를 호출하여 인스턴스 생성/반환
     * (share로 값이 있으면 그대로 반환)
     */
    public function make(string $key, ...$args)
    {
        $entry = $this->container[$key] ?? null;

        if ($entry === null) {
            throw new \RuntimeException("Service not found: {$key}");
        }

        if (is_callable($entry)) {
            // 팩토리면 호출하여 생성하고, 재사용을 원치 않으면 결과를 반환만 하고
            // 재사용(싱글톤) 원하면 외부에서 share()로 덮어쓰면 됨.
            return $entry($this, ...$args);
        }

        // share된 값이면 그대로 반환
        return $entry;
    }

    /**
     * @return Application
     */
    public static function getInstance()
    {
        if (!static::$instance) {
            throw new \RuntimeException('Application has not been initialized.');
        }
        return static::$instance;
    } 

    public function setLocale(string $locale): void {
        $this->locale = in_array($locale, locales(), true) ? $locale : DEFAULT_LOCALE;
    }
    public function getLocale(): string {
        return $this->locale;
    }

    protected function detectLocaleFromPath(string $path): array
    {
        $segments = array_values(array_filter(explode('/', trim($path, '/')), 'strlen'));
        $first    = $segments[0] ?? null;

        $hadPrefix = false;

        if ($first !== null && in_array($first, locales(), true)) {
            // /ko/... or /en/...
            $this->setLocale($first);
            array_shift($segments);
            $hadPrefix = true;
        } else {
            // prefix가 없으면 선호 로케일(쿠키/헤더/기본)
            $this->setLocale($this->detectPreferredLocale($this->request()));
        }

        $stripped = '/' . implode('/', $segments);
        if ($stripped !== '/' && substr($stripped, -1) === '/') {
            $stripped = rtrim($stripped, '/');
        }

        // [locale, strippedPath, hadPrefix]
        return [$this->getLocale(), $stripped, $hadPrefix];
    }



    public function router(): Router { return $this->router; }
    public function request(): Request { return $this->request; }
    public function response(): Response { return $this->response; }
    public function rootPath(): string { return $this->rootPath; }

    public function setRootPath(string $rootPath)
    {
        if (!is_dir($rootPath)) {
            throw new \RuntimeException('잘못된 루트 디렉토리입니다.');
        }
        $this->rootPath = $rootPath; 
    }
    

    protected function detectPreferredLocale(Request $req): string
    {
        // 1) 쿠키 우선 (있다면)
        if (!empty($_COOKIE['locale']) && in_array($_COOKIE['locale'], locales(), true)) {
            return $_COOKIE['locale'];
        }

        // 2) 브라우저 Accept-Language
        $hdr = (string)$req->header('Accept-Language', '');
        
        if ($hdr) {
            $langs = array_map('trim', explode(',', $hdr));
            foreach ($langs as $lang) {
                // "en-US;q=0.9" → "en"
                $code = strtolower(trim(explode(';', $lang)[0]));
                $code = substr($code, 0, 2);
                if (in_array($code, locales(), true)) {
                    return $code;
                }
            }
        }

        // 3) 기본
        return DEFAULT_LOCALE;
    }

    /**
     * 메인 디스패치: 라우팅 → 핸들러 실행 → 응답 정규화
     */
    public function handleRequest(): Response
    {
        $req    = $this->request();
        $res    = $this->response();
        $path   = $req->path();
        $method = $req->method();

        
        try {
             $originalPath = $req->path();

            // 로케일 감지 + path에서 제거 + prefix 유무
            [$loc, $path, $hadPrefix] = $this->detectLocaleFromPath($originalPath);

            // ★ prefix가 없으면 /{locale}{originalPath} 로 302 리다이렉트
            if (!$hadPrefix) {
                // 쿼리 유지
                $qs  = $_SERVER['QUERY_STRING'] ?? '';
                $locPrefix = '/' . rawurlencode($loc);
                // originalPath는 `/` 또는 `/contact` 같은 “원래 요청 경로”
                $location = $locPrefix . ($originalPath === '/' ? '' : $originalPath);
                if ($qs !== '') {
                    $location .= (strpos($location, '?') === false ? '?' : '&') . $qs;
                }
                return (new Response())->redirect($location, 302);
            }

            // prefix를 제거한 경로로 라우팅 매치
            $matched = $this->router->match($method, $path);

            if (!$matched) {
                return $this->makeErrorResponse(404, 'Not Found', $req);
            }

            $handler = $this->normalizeHandler($matched['handler']);
            $params  = $matched['params'] ?? [];

            $result = $this->invokeHandler($handler, $params);
            return $this->finalizeResponse($result, $req, $res);

        } catch (Throwable $e) {
            // Router가 MethodNotAllowed 의미를 담아 던지는 경우(클래스명/코드로 판별)
            $class = \get_class($e);
            if (stripos($class, 'MethodNotAllowed') !== false || $e->getCode() === 405) {
                $allowed = method_exists($e, 'getAllowedMethods') ? $e->getAllowedMethods() : [];
                return $this->makeMethodNotAllowed($req, $allowed);
            }
            // NotFound 예외
            if (stripos($class, 'NotFound') !== false || $e->getCode() === 404) {
                return $this->makeErrorResponse(404, 'Not Found', $req);
            }

            // 예기치 못한 오류 → 500
            return $this->makeErrorResponse(500, 'Internal Server Error', $req, isDevelopment() ? [
                'message' => $e->getMessage(),
                'file'    => $e->getFile(),
                'line'    => $e->getLine(),
                'trace'   => explode("\n", $e->getTraceAsString()),
            ] : null);
        }
    }

    /* ==================== 내부 유틸 ==================== */

    /**
     * 다양한 핸들러 표현을 callable로 정규화
     * - "Controller@method"
     * - [ControllerClass, 'method']
     * - ControllerClass::class (invoke)
     * - Closure / callable
     * @return Closure|callable
     */
    protected function normalizeHandler($handler)
    {
        if (is_callable($handler)) {
            return $handler;
        }

        // "Controller@method" 문자열
        if (is_string($handler) && strpos($handler, '@') !== false) {
            [$class, $method] = explode('@', $handler, 2);
            if (!class_exists($class)) {
                throw new \RuntimeException("Handler class not found: {$class}");
            }
            $instance = new $class();
            if (!is_callable([$instance, $method])) {
                throw new \RuntimeException("Handler method not callable: {$class}@{$method}");
            }
            return function (...$args) use ($instance, $method) {
                return $instance->{$method}(...$args);
            };
        }

        // 클래스명만 온 경우 -> __invoke()
        if (is_string($handler) && class_exists($handler)) {
            $instance = new $handler();
            if (!is_callable($instance)) {
                throw new \RuntimeException("Handler is not invokable: {$handler}");
            }
            return $instance; // __invoke
        }

        // 배열 [class-string|object, method]
        if (is_array($handler) && count($handler) === 2) {
            [$classOrObj, $method] = $handler;
            $instance = is_object($classOrObj) ? $classOrObj : new $classOrObj();
            if (!is_callable([$instance, $method])) {
                $className = is_object($instance) ? get_class($instance) : (string)$instance;
                throw new \RuntimeException("Handler method not callable: {$className}@{$method}");
            }
            return function (...$args) use ($instance, $method) {
                return $instance->{$method}(...$args);
            };
        }

        throw new \RuntimeException('Unsupported route handler type.');
    }

    /**
     * 핸들러 호출: (Request, Response, ...params) → result
     * @var callable $handler
     */
    protected function invokeHandler($handler, array $routeParams)
    {
        // 시그니처 유연 대응: 대부분 (Request $req, Response $res, ...$params)
        return $handler($this->request(), $this->response(), ...array_values($routeParams));
    }

    /**
     * 핸들러의 반환값을 Response로 정규화
     */
    protected function finalizeResponse($result, Request $req, Response $res): Response
    {
        // 이미 Response면 그대로
        if ($result instanceof Response) {
            return $result;
        }

        // null → 204
        if ($result === null) {
            return (new Response())->setStatus(204);
        }

        // 배열/객체 → JSON
        if (is_array($result) || is_object($result)) {
            return (new Response())->json($result, 200);
        }

        // 문자열 → HTML
        if (is_string($result)) {
            return (new Response($result, 200))->header('Content-Type', 'text/html; charset=utf-8');
        }

        // 기타 스칼라 → 문자열로 변환
        if (is_scalar($result)) {
            $content = (string)$result;
            return (new Response($content, 200))->header('Content-Type', 'text/plain; charset=utf-8');
        }

        // 알 수 없는 타입 → 500
        return $this->makeErrorResponse(500, 'Unsupported Response Type', $req);
    }

    /**
     * 404/500 등 에러 응답 생성 (간단한 협상)
     */
    protected function makeErrorResponse(int $status, string $message, Request $req, ?array $payload = null): Response
    {
        $accept = strtolower((string)$req->header('Accept', ''));
        $isJson = strpos($accept, 'application/json') !== false;

        if ($isJson) {
            $data = ['status' => $status, 'error' => $message];
            if ($payload !== null) {
                $data['debug'] = $payload;
            }
            return (new Response())->json($data, $status);
        }

        $html = "<h1>{$status} {$message}</h1>";
        if ($payload && isDevelopment()) {
            $html .= '<pre style="white-space:pre-wrap;">' . htmlspecialchars(print_r($payload, true), ENT_QUOTES, 'UTF-8') . '</pre>';
        }
        return (new Response($html, $status))->header('Content-Type', 'text/html; charset=utf-8');
    }

    /**
     * 405 응답 + Allow 헤더
     */
    protected function makeMethodNotAllowed(Request $req, array $allowed = []): Response
    {
        $allowed = array_map('strtoupper', $allowed);
        $allowedHeader = implode(', ', $allowed) ?: 'GET, POST, PUT, PATCH, DELETE, OPTIONS';
        return (new Response('', 405))
            ->header('Allow', $allowedHeader)
            ->header('Content-Type', 'text/plain; charset=utf-8')
            ->setContent('Method Not Allowed');
    }
}