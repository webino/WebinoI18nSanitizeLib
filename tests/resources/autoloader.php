<?php

namespace WebinoI18nSanitizeLib;

use WebinoDev\Test\Autoloader;

/**
 * Initialize vendor autoloader
 */
if (empty($loader = @include __DIR__ . '/../../vendor/autoload.php')) {
    throw new \RuntimeException('Unable to load. Run `php composer.phar install`.');
}

class_exists(Autoloader::class)
    and call_user_func(new Autoloader(__DIR__, __NAMESPACE__), $loader);
