<?php

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
