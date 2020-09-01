<?php


namespace PlayWrightClient\Api\Structures;


class Header
{
    /**
     * @var string
     */
    private $name;
    /**
     * @var string
     */
    private $value;

    public function __construct(string $name, string $value)
    {
        $this->name = $name;
        $this->value = $value;
    }

    public function toArray(): array
    {
        return [$this->name => $this->value];
    }
}
