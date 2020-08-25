<?php


namespace PlayWrightClient\Api;


use PlayWrightClient\Js;

class Page extends Js
{
    private $pageVarName;

    public function __construct(string $pageVarName, string &$customJsStore = '')
    {
        $this->pageVarName = $pageVarName;
        parent::__construct($customJsStore);
    }

}
