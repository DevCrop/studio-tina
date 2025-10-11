<?php

if (!function_exists('isDevelopment')) {
    function isDevelopment() {
        return ENV === ENV_DEVELOPMENT; 
    }
}

if (!function_exists('isProduction')) {
    function isProduction() {
        return ENV === ENV_PRODUCTION;
    }
}

if (!function_exists('set_locale')) {
    function set_locale(string $locale): void {
        $locale = in_array($locale, locales(), true) ? $locale : DEFAULT_LOCALE;
        $app = app();
        if (method_exists($app, 'setLocale')) {
            $app->setLocale($locale);
        } else {
            $GLOBALS['app_locale'] = $locale;
        }
    }
}


if (!function_exists('locale')) {
    function locale(): string {
        $app = app();
        if (method_exists($app, 'getLocale')) return $app->getLocale();
        return $GLOBALS['app_locale'] ?? DEFAULT_LOCALE;
    }
}

/** 번역: /lang/{locale}.php에서 배열 로드, 'a.b.c' 점 표기 지원 */
if (!function_exists('__')) {
    function __(string $key, array $replace = [], ?string $default = null): string {
        static $cache = [];
        $loc = locale();
        if (!isset($cache[$loc])) {
            $file = rtrim(ROOT_PATH, '/').'/lang/'.$loc.'.php';
            $cache[$loc] = is_file($file) ? (include $file) : [];
        }
        $val = array_reduce(explode('.', $key), function($carry, $segment) {
            if (is_array($carry) && array_key_exists($segment, $carry)) return $carry[$segment];
            return null;
        }, $cache[$loc]);

        if ($val === null) $val = $default ?? $key;

        if ($replace) {
            foreach ($replace as $k => $v) $val = str_replace(':'.$k, (string)$v, $val);
        }
        return (string)$val;
    }
}

if (!function_exists('dump')) {
    /**
     * 변수 디버깅 출력 (라라벨 dump() 유사)
     *
     * @param mixed ...$vars
     * @return void
     */
    function dump(...$vars): void
    {
        foreach ($vars as $var) {
            echo '<pre style="background:#222;color:#eee;padding:10px;border-radius:6px;white-space:pre-wrap;font-size:13px;line-height:1.4">';
            echo htmlspecialchars(print_r($var, true), ENT_QUOTES, 'UTF-8');
            echo '</pre>';
        }
    }
}

if (!function_exists('dd')) {
    /**
     * Dump and Die (라라벨 dd() 유사)
     *
     * @param mixed ...$vars
     * @return never
     */
    function dd(...$vars): void
    {
        dump(...$vars);
        exit(1);
    }
}

if (!function_exists('e')) {
    function e(string $string) {
        return htmlspecialchars((string)$string, ENT_QUOTES, 'UTF-8', false);
    }
}

if (!function_exists('locales')) {
    function locales(): array {
        return array_keys(LOCALES);
    }
}