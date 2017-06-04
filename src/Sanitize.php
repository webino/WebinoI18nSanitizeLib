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

use Zend\Filter;
use Zend\Filter\Exception;

/**
 * Class Sanitize
 *
 * @author Martin Hujer mhujer@gmail.com
 */
class Sanitize implements Filter\FilterInterface
{
    /**
     * Character(s) used to replace delimiters
     *
     * @var string
     */
    protected $delimiterReplacement;

    /**
     * Word delimiters which are replaced by spaceReplacement string
     *
     * @var array
     */
    protected $wordDelimiters = [' ', '.', '\\', '/', '-', '_'];

    /**
     * Which characters are not replaced
     *
     * @var array
     */
    protected $notReplacedChars = [];

    /**
     * @var Transliteration
     */
    protected $transliteration;

    /**
     * @var Filter\StringTrim
     */
    protected $stringTrim;

    /**
     * @var Filter\StringToLower
     */
    protected $stringToLower;

    /**
     *
     * @param string $delimiterReplacement
     * @param string|array $wordDelimiters
     */
    public function __construct($delimiterReplacement = '-', $wordDelimiters = null)
    {
        $this->setDelimiterReplacement($delimiterReplacement);
        if (null !== $wordDelimiters) {
            $this->addWordDelimiter($wordDelimiters);
        }
    }

    /**
     * Returns $value filtered to valid URL
     *
     * @param string $s
     * @return string
     */
    public function filter($s)
    {
        // convert to ascii -> translate strange chars
        $s = $this->getTransliteration()->filter($s);
        // trim spaces
        $s = $this->getStringTrim()->filter($s);
        // replace delimiters with another character
        $s = $this->replaceDelimiters($s);
        // lower chars
        $s = $this->getStringToLower()->filter($s);
        // delete chars except a-z0-9
        $s = $this->trimSpecialsChars($s);
        // replace double dashes with single one
        $s = $this->replaceDoubleDelimiterReplacementWithSingle($s);
        // trim dashes on beginning/end of the string
        $s = $this->trimStartAndEndSpaceReplacement($s);
        return $s;
    }

    /**
     * @return Transliteration
     */
    public function getTransliteration()
    {
        if (null === $this->transliteration) {
            $this->transliteration = new Transliteration;
        }
        return $this->transliteration;
    }

    /**
     * @param Transliteration $transliteration
     * @return $this
     */
    public function setTransliteration(Transliteration $transliteration)
    {
        $this->transliteration = $transliteration;
        return $this;
    }

    /**
     * @return Filter\StringTrim
     */
    public function getStringTrim()
    {
        if (null === $this->stringTrim) {
            $this->stringTrim = new Filter\StringTrim;
        }
        return $this->stringTrim;
    }

    /**
     * @param Filter\StringTrim $stringTrim
     * @return $this
     */
    public function setStringTrim(Filter\StringTrim $stringTrim)
    {
        $this->stringTrim = $stringTrim;
        return $this;
    }

    /**
     * @return Filter\StringToLower
     */
    public function getStringToLower()
    {
        if (null === $this->stringToLower) {
            $this->stringToLower = new Filter\StringToLower;
            $this->stringToLower->setEncoding('utf-8');
        }
        return $this->stringToLower;
    }

    /**
     * @param Filter\StringToLower $stringToLower
     * @return $this
     */
    public function setStringToLower(Filter\StringToLower $stringToLower)
    {
        $this->stringToLower = $stringToLower;
        return $this;
    }

    /**
     * @param string|array $notReplaced
     * @return $this
     * @throws Exception\RuntimeException
     */
    public function addNotReplacedChars($notReplaced)
    {
        if (in_array($notReplaced, $this->getNotReplacedChars())) {
            throw new Exception\RuntimeException("Not replaced characterr '$notReplaced' is already there.");
        }

        if (empty($notReplaced)) {
            throw new Exception\RuntimeException('Not replaced character cannot be null.');
        }

        if (is_array($notReplaced)) {
            $this->notReplacedChars = array_merge($this->getNotReplacedChars(), $notReplaced);
        } else {
            $this->notReplacedChars[] = $notReplaced;
        }

        return $this;
    }

    /**
     * Returns chars which are not replaced
     *
     * @return array
     */
    public function getNotReplacedChars()
    {
        return $this->notReplacedChars;
    }

    /**
     * Remove not replaced character
     *
     * @param string|array $notReplaced
     * @return $this
     * @throws Exception\RuntimeException
     */
    public function removeNotReplacedChar($notReplaced)
    {
        if (empty($notReplaced)) {
            throw new Exception\RuntimeException('Not replaced character cannot be null.');
        }

        if (is_array($notReplaced)) {
            foreach ($notReplaced as $n) {
                $this->removeNotReplacedChar($n);
            }
        } else {
            if (!in_array($notReplaced, $this->getNotReplacedChars())) {
                throw new Exception\RuntimeException("Not replaced character '$notReplaced' is not in array.");
            }

            $notReplacedChars = [];
            foreach ($this->notReplacedChars as $n) {
                if ($n != $notReplaced) {
                    $notReplacedChars[] = $n;
                }
                $this->notReplacedChars = $notReplacedChars;
            }
        }

        return $this;
    }

    /**
     * Returns the delimiterReplacement option
     *
     * @return string
     */
    public function getDelimiterReplacement()
    {
        return $this->delimiterReplacement;
    }

    /**
     * Sets the delimiterReplacement option
     *
     * @param string $delimiterReplacement
     * @return $this
     */
    public function setDelimiterReplacement($delimiterReplacement)
    {
        $this->delimiterReplacement = $delimiterReplacement;
        return $this;
    }

    /**
     * Returns word delimiters array
     *
     * @return array
     */
    public function getWordDelimiters()
    {
        return $this->wordDelimiters;
    }

    /**
     * Add word delimiter
     *
     * @param string|array $delimiter
     * @return $this
     * @throws Exception\RuntimeException
     */
    public function addWordDelimiter($delimiter)
    {
        if (in_array($delimiter, $this->getWordDelimiters())) {
            throw new Exception\RuntimeException("Word delimiter '$delimiter' is already there.");
        }

        if (empty($delimiter)) {
            throw new Exception\RuntimeException('Word delimiter cannot be null.');
        }

        if (is_array($delimiter)) {
            $this->wordDelimiters = array_merge($this->getWordDelimiters(), $delimiter);
        } else {
            $this->wordDelimiters[] = $delimiter;
        }

        return $this;
    }

    /**
     * Remove word delimiter
     *
     * @param string|array $delimiters
     * @return $this
     * @throws Exception\RuntimeException
     */
    public function removeWordDelimiter($delimiters)
    {
        if (empty($delimiters)) {
            throw new Exception\RuntimeException('Word delimiter cannot be null.');
        }

        if (is_array($delimiters)) {
            foreach ($delimiters as $delimiter) {
                $this->removeWordDelimiter($delimiter);
            }
        } else {
            if (!in_array($delimiters, $this->getWordDelimiters())) {
                throw new Exception\RuntimeException("Word delimiter '$delimiters' is not in delimiters array.");
            }

            $wordDelimiters = [];
            foreach ($this->wordDelimiters as $delimiter) {
                if ($delimiter != $delimiters) {
                    $wordDelimiters[] = $delimiter;
                }
                $this->wordDelimiters = $wordDelimiters;
            }
        }

        return $this;
    }

    /**
     * Replace delimiters with another string
     *
     * @param string $s
     * @return string
     */
    private function replaceDelimiters($s)
    {
        foreach ($this->getWordDelimiters() as $delimiter) {

            if ($delimiter == $this->getDelimiterReplacement()) {
                continue;
            }

            if (in_array($delimiter, $this->getNotReplacedChars())) {
                continue;
            }

            $s = str_replace($delimiter, $this->getDelimiterReplacement(), $s);
        }

        return $s;
    }

    /**
     * To special chars
     *
     * @param string $s
     * @return string
     */
    private function trimSpecialsChars($s)
    {
        if (count($this->getNotReplacedChars()) == 0) {
            $reg = '~[^-a-z0-9_]+~';
        } else {
            $reg = '~[^-a-z0-9_' . implode('', $this->getNotReplacedChars()) . ']+~';
        }
        return preg_replace($reg, '', $s);
    }

    /**
     * Replace double delimiter with single one
     *
     * @param string $s
     * @return string
     */
    private function replaceDoubleDelimiterReplacementWithSingle($s)
    {
        $doubleDelimiterReplacement = $this->getDelimiterReplacement() . $this->getDelimiterReplacement();
        while (strpos($s, $doubleDelimiterReplacement) !== false) {
            $s = str_replace($doubleDelimiterReplacement, $this->getDelimiterReplacement(), $s);
        }
        return $s;
    }

    /**
     * Trim dashes on beginning/end of the string
     *
     * @param string $s
     * @return string
     */
    private function trimStartAndEndSpaceReplacement($s)
    {
        return trim($s, $this->getDelimiterReplacement());
    }
}
