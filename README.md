# Webino International Sanitize Library

[![Build Status](https://secure.travis-ci.org/webino/WebinoI18nSanitizeLib.png?branch=develop)](http://travis-ci.org/webino/WebinoI18nSanitizeLib "Develop Build Status")
[![Coverage Status](https://coveralls.io/repos/webino/WebinoI18nSanitizeLib/badge.png?branch=develop)](https://coveralls.io/r/webino/WebinoI18nSanitizeLib?branch=develop "Develop Coverage Status")
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/webino/WebinoI18nSanitizeLib/badges/quality-score.png?b=develop)](https://scrutinizer-ci.com/g/webino/WebinoI18nSanitizeLib/?branch=develop "Develop Quality Score")
<br />
[![Latest Stable Version](https://poser.pugx.org/webino/webino-i18n-sanitize-lib/v/stable.svg)](https://packagist.org/packages/webino/webino-i18n-sanitize-lib)
[![Latest Unstable Version](https://poser.pugx.org/webino/webino-i18n-sanitize-lib/v/unstable.svg)](https://packagist.org/packages/webino/webino-i18n-sanitize-lib)
[![Total Downloads](https://poser.pugx.org/webino/webino-i18n-sanitize-lib/downloads.svg)](https://packagist.org/packages/webino/webino-i18n-sanitize-lib)
[![License](https://poser.pugx.org/webino/webino-i18n-sanitize-lib/license.svg)](https://packagist.org/packages/webino/webino-i18n-sanitize-lib)

Based on [Martin Hujer's Components](https://github.com/webino/MhujerZF1Classes)

## Features

  - Sanitize international string

## Setup

  - Run: `php composer.phar require webino/webino-i18n-sanitize-lib:dev-develop`

## QuickStart

    $sanitize = new \WebinoI18nSanitizeLib\Sanitize;
    $sanitize->filter('šľžťýá'); // returns slztya

## Addendum

Please, if you are interested in this Webino™ library, report any issues and don't hesitate to contribute.
