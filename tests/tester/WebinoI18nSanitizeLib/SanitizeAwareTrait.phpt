<?php
/**
 * Webino (http://webino.sk)
 *
 * @link        https://github.com/webino/WebinoI18nSanitizeLib for the canonical source repository
 * @copyright   Copyright (c) 2017 Webino, s. r. o. (http://webino.sk)
 * @author      Peter Bačinský <peter@bacinsky.sk>
 * @license     BSD-3-Clause
 */

use Tester\Assert;
use WebinoI18nSanitizeLib\Sanitize;
use WebinoI18nSanitizeLib\SanitizeAwareTrait;

require __DIR__ . '/../bootstrap.php';


class TestSanitizer
{
    use SanitizeAwareTrait;
}


$sanitizer = new TestSanitizer;
Assert::type(Sanitize::class, $sanitizer->getSanitize());


$sanitize = new Sanitize;
$sanitizer->setSanitize($sanitize);
Assert::equal($sanitize, $sanitizer->getSanitize());
