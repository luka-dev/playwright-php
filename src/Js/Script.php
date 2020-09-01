<?php


namespace PlayWrightClient\Js;


class Script
{
    protected $jsString;

    /**
     * Builder constructor.
     * Here can be passed address of shared Builder var storage
     * @param string $customJsStore
     */
    public function __construct(string &$customJsStore = '')
    {
        $this->jsString = $customJsStore;
    }

    /**
     * Adding js to the end
     *
     * @param string $js
     * @param bool $needNewLine
     * @param bool $semicolon
     * @return void
     */
    final public function append(string $js, bool $needNewLine = true, bool $semicolon = true): void
    {
        $this->jsString .= $js;
        if ($semicolon) {
            $this->jsString .= ';';
        }
        if ($needNewLine) {
            $this->jsString .= PHP_EOL;
        }
    }

    /**
     * Adding js to the beginning
     *
     * @param string $js
     * @param bool $needNewLine
     * @param bool $semicolon
     * @return void
     */
    final public function prepend(string $js, bool $needNewLine = true, bool $semicolon = true): void
    {
        if ($semicolon) {
            $js .= ';';
        }
        if ($needNewLine) {
            $js .= PHP_EOL;
        }
        $this->jsString = $js . $this->jsString;
    }

    /**
     * get simple Js as a string
     *
     * @return string
     */
    public function getJs(): string
    {
        return $this->jsString;
    }
}
