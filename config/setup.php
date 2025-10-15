<?php 

define('ROOT_PATH', dirname(__DIR__));
define('IMG_PATH', '/resource/images');

define('ENV_PRODUCTION', 'production');
define('ENV_DEVELOPMENT', 'development');

define('FORCE_LOCALE_PREFIX', false);

define('LOCALES', [
    'ko' => 'ko-KR',
    'en' => 'en-US',
]);

define('DEFAULT_LOCALE', 'ko');

/**
 * Change mode here
 */
define('ENV', ENV_DEVELOPMENT);