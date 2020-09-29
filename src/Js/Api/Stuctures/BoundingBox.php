<?php


namespace PlayWrightClient\Api\Structures;


use PlayWrightClient\Js\Builder;

class BoundingBox
{
    private $boundingBoxVarName;

    public function __construct(string $boundingBoxVarName)
    {
        $this->boundingBoxVarName = $boundingBoxVarName;
    }

    public function getBoundingBoxVarName(): string
    {
        return $this->boundingBoxVarName;
    }

    public function x(): string {
        return $this->boundingBoxVarName.'.x';
    }

    public function y(): string {
        return $this->boundingBoxVarName.'.x';
    }

    public function height(): string {
        return $this->boundingBoxVarName.'.height';
    }

    public function width(): string {
        return $this->boundingBoxVarName.'.width';
    }

    public function centerHeight(): string
    {
        return "($this->boundingBoxVarName.y + ($this->boundingBoxVarName.height / 2))";
    }
    public function centerWidth(): string
    {
        return "($this->boundingBoxVarName.x + ($this->boundingBoxVarName.width / 2))";
    }
}
