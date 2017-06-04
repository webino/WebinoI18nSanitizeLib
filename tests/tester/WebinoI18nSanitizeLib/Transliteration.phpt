<?php

use Tester\Assert;
use WebinoI18nSanitizeLib\Transliteration;
use Zend\Filter\Exception;

require __DIR__ . '/../bootstrap.php';


$transliteration = new Transliteration;


// test Slovak
Assert::equal('aAaAcCdDeE', $transliteration->filter('áÁäÄčČďĎéÉ'));
Assert::equal('iIlLlLnNoOoO', $transliteration->filter('íÍĺĹľĽňŇóÓôÔ'));
Assert::equal('rRsStTuUYyzZ', $transliteration->filter('ŕŔšŠťŤúÚÝýžŽ'));


// test Czech
Assert::equal('escrzyaieuu', $transliteration->filter('ěščřžýáíéůú'));


// test diacritic
Assert::equal('', $transliteration->filter('ˇ´'));


// test Czech sentence
$czech = 'Příliž žluťoučký kůň úpěl ďábelské ody!';
$converted = 'Priliz zlutoucky kun upel dabelske ody!';
Assert::equal($converted, $transliteration->filter($czech));


// test German
Assert::equal('e-i-oe-ue', $transliteration->filter('ë-ï-ö-ü'));
Assert::equal('E-I-Oe-Ue', $transliteration->filter('Ë-Ï-Ö-Ü'));
Assert::equal('ss', $transliteration->filter('ß'));


// test French
Assert::equal('aeiou', $transliteration->filter('âêîôû'));
Assert::equal('AEIOU', $transliteration->filter('ÂÊÎÔÛ'));
Assert::equal('oe', $transliteration->filter('œ'));
Assert::equal('ae', $transliteration->filter('æ'));
Assert::equal('Y', $transliteration->filter('Ÿ'));
Assert::equal('Cc', $transliteration->filter('Çç'));


// test Hungarian
Assert::equal('aeioouu', $transliteration->filter('áéíóőúű'));


// test Russian
Assert::equal('korzina', $transliteration->filter('kорзина'));
Assert::equal('studjenchjeskije rjukzaki', $transliteration->filter('студенческие рюкзаки'));


// test Polish
Assert::equal('aoclesnzz', $transliteration->filter('ąóćłęśńżź'));
Assert::equal('aeoclnszzOCLSZZ', $transliteration->filter('ąęóćłńśżźÓĆŁŚŻŹ'));


// test Polish sentence
$polish = 'Pchnąć w tę łódź jeża lub ośm skrzyń fig.';
$converted = 'Pchnac w te lodz jeza lub osm skrzyn fig.';
Assert::equal($converted, $transliteration->filter($polish));


// test Danish
Assert::equal('ae oe aa Ae Oe Aa', $transliteration->filter('æ ø å Æ Ø Å'));


// test Danish sentence
$danish = 'På Falster, i nærheden af Nykøbing.';
$converted = 'Paa Falster, i naerheden af Nykoebing.';
Assert::equal($converted, $transliteration->filter($danish));


// test Croatian
Assert::equal('cczsdCCZSD', $transliteration->filter('čćžšđČĆŽŠĐ'));


// test not transliterate
Assert::equal("'", $transliteration->filter("'"));
Assert::equal('"', $transliteration->filter('"'));
Assert::equal('^', $transliteration->filter('^'));
