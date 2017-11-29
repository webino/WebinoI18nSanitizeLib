<?php
/**
 * Webino (http://webino.sk)
 *
 * @link        https://github.com/webino/WebinoI18nSanitizeLib for the canonical source repository
 * @copyright   Copyright (c) 2017 Webino, s. r. o. (http://webino.sk)
 * @author      Peter Bačinský <peter@bacinsky.sk>
 * @license     BSD-3-Clause
 */

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
