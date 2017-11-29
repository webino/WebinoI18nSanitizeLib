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

/**
 * Trait SanitizeAwareTrait
 */
trait SanitizeAwareTrait
{
    /**
     * @var Sanitize
     */
    protected $sanitize;

    /**
     * @return Sanitize
     */
    public function getSanitize()
    {
        if (null === $this->sanitize) {
            $this->sanitize = new Sanitize;
        }
        return $this->sanitize;
    }

    /**
     * @param Sanitize $sanitize
     * @return $this
     */
    public function setSanitize(Sanitize $sanitize)
    {
        $this->sanitize = $sanitize;
        return $this;
    }
}
