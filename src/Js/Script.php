<?php


namespace PlayWrightClient\Js;


use Exception;

class Script
{
    protected $jsString;

    protected $requestTimeout = 30;

    /**
     * Builder constructor.
     * Here can be passed address of shared Builder var storage
     * @param string $customJsStore
     * @param int $requestTimeout
     */
    public function __construct(string &$customJsStore = '', int &$requestTimeout = 30)
    {
        $this->jsString = &$customJsStore;
        $this->requestTimeout = &$requestTimeout;
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

    public function addToTimeout(int $milliseconds): void
    {
        $this->requestTimeout += $milliseconds / 1000;
    }

    public function setTimeout(int $seconds): void
    {
        $this->requestTimeout = $seconds;
    }

    public function getTimeout(): int
    {
        return $this->requestTimeout;
    }

    public function loadFromFile(string $pathToJs): void
    {
        $content = file_get_contents($pathToJs);
        if ($content === false) {
            throw new \RuntimeException('cant read script file');
        }
        $this->jsString = $content;
    }
}
