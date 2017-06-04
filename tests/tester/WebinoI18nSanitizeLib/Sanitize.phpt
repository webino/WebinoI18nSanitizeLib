<?php

use Tester\Assert;
use WebinoI18nSanitizeLib\Sanitize;
use Zend\Filter\Exception;

require __DIR__ . '/../bootstrap.php';


// test constructor
$sanitize = new Sanitize('_', '!');
Assert::equal('test_word_test', $sanitize->filter('test!word!test'));


// test constructor array
$sanitize = new Sanitize('_', ['!', ':']);
Assert::equal('test_word_test', $sanitize->filter('test!word:test'));


// test set delimiter replacement
$sanitize = new Sanitize;
$sanitize->setDelimiterReplacement('_');
Assert::equal('_', $sanitize->getDelimiterReplacement());


// test add word delimiter
$sanitize = new Sanitize;
$delimiters = $sanitize->getWordDelimiters();
$delimiters[] = '=';
$sanitize->addWordDelimiter('=');
Assert::equal($delimiters, $sanitize->getWordDelimiters());


// test add word delimiter array
$sanitize = new Sanitize;
$delimiters = $sanitize->getWordDelimiters();
$delimiters[] = '=';
$delimiters[] = '!';
$sanitize->addWordDelimiter(['=', '!']);
Assert::equal($delimiters, $sanitize->getWordDelimiters());


// test add word delimiter already added exception
Assert::exception(function () {
    $sanitize = new Sanitize;
    $sanitize->addWordDelimiter('=');
    $sanitize->addWordDelimiter('=');
}, Exception\RuntimeException::class, 'Word delimiter \'=\' is already there.');


// test add word delimiter empty exception
Assert::exception(function () {
    $sanitize = new Sanitize;
    $sanitize->addWordDelimiter('');
}, Exception\RuntimeException::class, 'Word delimiter cannot be null.');


// test remove word delimiter
$sanitize = new Sanitize;
$sanitize->addWordDelimiter('=');
Assert::equal('foo-url', $sanitize->filter("foo=url"));
$sanitize->removeWordDelimiter('=');
Assert::notEqual('foo-url', $sanitize->filter("foo=url"));


// test remove word delimiter array
$sanitize = new Sanitize;
$sanitize->addWordDelimiter('=');
$sanitize->addWordDelimiter('!');
Assert::equal('foo-bar-baz', $sanitize->filter('foo=bar!baz'));
$sanitize->removeWordDelimiter(['=', '!']);
Assert::equal('foobarbaz', $sanitize->filter('foo=bar!baz'));


// test remove word delimiter empty exception
Assert::exception(function () {
    $sanitize = new Sanitize;
    $sanitize->removeWordDelimiter('');
}, Exception\RuntimeException::class, 'Word delimiter cannot be null.');


// test trim spaces
$sanitize = new Sanitize;
Assert::equal('foo-url', $sanitize->filter("\t\n  foo-url "));


// test replace spaces
$sanitize = new Sanitize;
Assert::equal('foo-url', $sanitize->filter('foo url'));
$sanitize->setDelimiterReplacement('_');
Assert::equal('foo_url', $sanitize->filter('foo url'));


// test replace double delimiter with single replacement
$sanitize = new Sanitize;
Assert::equal('foo-url', $sanitize->filter('foo--url'));
$sanitize->setDelimiterReplacement('_');
Assert::equal('foo_url', $sanitize->filter('foo__url'));


// test to lower
$sanitize = new Sanitize;
Assert::equal('escrzyaieuu', $sanitize->filter('ESCRZYAIEUU'));


// test dots replacement
$sanitize = new Sanitize;
Assert::equal('foo-url', $sanitize->filter('foo.url'));


// test slashes replacement
$sanitize = new Sanitize;
Assert::equal('foo-url', $sanitize->filter('foo/url'));
Assert::equal('foo-url', $sanitize->filter('foo\url'));


// test trim start and end space replacement
$sanitize = new Sanitize;
Assert::equal('foo-url', $sanitize->filter('--foo-url--'));
$sanitize->setDelimiterReplacement('_');
Assert::equal('foo_url', $sanitize->filter('__foo-url__'));


// test trim special chars
$sanitize = new Sanitize;
Assert::equal('foo-url', $sanitize->filter('foo-url\'?&@{}\\[]"'));


// test normalize filename
$sanitize = new Sanitize;
$sanitize->addNotReplacedChars('.');
Assert::equal('mozilla-firefox-1.0.0.12.exe', $sanitize->filter('MoZIlla FiREfOx 1.0.0.12.EXE'));
$sanitize->removeNotReplacedChar('.');
Assert::equal('mozilla-firefox-1-0-0-12-exe', $sanitize->filter('MoZIlla FiREfOx 1.0.0.12.EXE'));


// test convert string to url
$sanitize = new Sanitize;
Assert::equal('foo-url', $sanitize->filter('-- F*OÓ !-úřl\'?&@{ }\\[]"'));


// test convert string to url 2
$sanitize = new Sanitize;
Assert::equal('arvizturo-tuekoerfurogep', $sanitize->filter('Árvíztűrő tükörfúrógép'));
