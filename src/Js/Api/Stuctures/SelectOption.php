<?php


namespace PlayWrightClient\Api\Structures;


class SelectOption
{
    /**
     * @var string Matches by option.value
     */
    private $value = null;
    /**
     * @var string Matches by option.label
     */
    private $label = null;
    /**
     * @var int  Matches by the index
     */
    private $number = null;

    public function __construct(string $value, string $label, int $number)
    {
        $this->value = $value;
        $this->label = $label;
        $this->number = $number;
    }

    public function toArray(): array
    {
        $arr = [];

        if ($this->value !== null) {
            $arr['value'] = $this->value;
        }
        if ($this->label !== null) {
            $arr['label'] = $this->label;
        }
        if ($this->number !== null) {
            $arr['number'] = $this->number;
        }

        return $arr;
    }
}
