<?php

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
