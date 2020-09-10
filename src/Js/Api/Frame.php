<?php


namespace PlayWrightClient\Api;


use PlayWrightClient\Js\Builder;

class Frame extends Builder
{
    private $frameVarName;

    public function __construct(string $frameVarName, string &$customJsStore = '', int &$requestTimeout = 30)
    {
        $this->frameVarName = $frameVarName;
        parent::__construct($customJsStore, $requestTimeout);
    }

}
