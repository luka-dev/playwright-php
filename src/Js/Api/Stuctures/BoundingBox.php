<?php


namespace PlayWrightClient\Api\Structures;


use PlayWrightClient\Js\Builder;

class BoundingBox extends Builder
{
    private $boundingBoxVarName;

    public function __construct(string $boundingBoxVarName, string &$customJsStore = '', int &$requestTimeout = 30)
    {
        $this->boundingBoxVarName = $boundingBoxVarName;
        parent::__construct($customJsStore,$requestTimeout);
    }

    public function getBoundingBoxVarName(): string
    {
        return $this->boundingBoxVarName;
    }

    public function x(): string {
        return $this->boundingBoxVarName.'x';
    }

    public function y(): string {
        return $this->boundingBoxVarName.'x';
    }

    public function height(): string {
        return $this->boundingBoxVarName.'height';
    }

    public function width(): string {
        return $this->boundingBoxVarName.'width';
    }

    public function centerHeight(): string
    {
        return "(($this->boundingBoxVarName.x + $this->boundingBoxVarName.height) / 2)";
    }
    public function centerWidth(): string
    {
        return "(($this->boundingBoxVarName.y + $this->boundingBoxVarName.width) / 2)";
    }
}
