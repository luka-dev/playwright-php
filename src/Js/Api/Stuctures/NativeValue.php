<?php


namespace PlayWrightClient\Api\Structures;


class NativeValue
{
    private $data = null;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function getData()
    {
        return $this->data;
    }

}
