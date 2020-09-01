<?php

namespace PlayWrightClient\Js;

use PlayWrightClient\Api\Context;
use PlayWrightClient\Exception\JsError;

class Builder extends Script
{

    public function toVar(string $varName): void
    {
        Vars::toVar($varName, $this);
    }

    public function wrapInBrackets(): Builder
    {
        $this->prepend('(', false, false);
        $this->append(')', false, false);

        return $this;
    }

    public function wrapInFunction(string $funcName): Builder
    {
        $this->wrapInBrackets();

        $this->prepend($funcName, false, false);

        return $this;
    }

    /**
     * @param Script $builder
     */
    public function merge(Script $builder): void
    {
        $this->append($builder->getJs(), true, false);
    }

    /**
     * @param int $index
     * @return Builder
     */
    public function index(int $index)
    {
        return $this->key((string)$index);
    }

    /**
     * @param string $key
     * @return Builder
     */
    public function key(string $key)
    {
        //removing spacing and commas
        $this->jsString = rtrim($this->jsString, " \t\n\r\0\x0B;");
        $this->wrapInBrackets();
        $this->append('[' . $key . ']');

        return $this;
    }

}
