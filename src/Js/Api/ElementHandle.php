<?php


namespace PlayWrightClient\Api;


use PlayWrightClient\Js\Builder;
use PlayWrightClient\Js\Functions;

class ElementHandle extends Builder
{
    private $elementVarName;

    public function __construct(string $elementVarName, string &$customJsStore = '')
    {
        $this->elementVarName = $elementVarName;
        parent::__construct($customJsStore);
    }


    /**
     * @param string $selector
     * @param string $button left|right|middle
     * @param int $clickCount
     * @param int $delay btw clicks in milliseconds
     * @param array $modifiers ["Alt"|"Control"|"Meta"|"Shift"] or empty
     * @param bool $force Whether to bypass the actionability checks
     * @param int $timeout
     */
    public function click(string $selector, string $button = 'left', int $clickCount = 1, int $delay = 0, array $modifiers = [], bool $force = false, int $timeout = 30000): void
    {
        $options = [
            'button' => $button,
            'clickCount' => $clickCount,
            'delay' => $delay,
            'modifiers' => $modifiers,
            'force' => $force,
            'timeout' => $timeout,
        ];

        $builder = Functions::callAwaitSafe("$this->elementVarName.click", $selector, $options);
        $this->merge($builder);
    }

    /**
     * @param string $selector
     * @param int $timeout
     */
    public function uncheck(string $selector, int $timeout = 3000): void
    {

        $options = [
            'timeout' => $timeout,
        ];

        $builder = Functions::callAwaitSafe("$this->elementVarName.uncheck", $selector, $options);
        $this->merge($builder);
    }

    /**
     * @param string $selector
     * @param int $timeout
     */
    public function check(string $selector, int $timeout = 3000): void
    {

        $options = [
            'timeout' => $timeout,
        ];

        $builder = Functions::callAwaitSafe("$this->elementVarName.check", $selector, $options);
        $this->merge($builder);
    }

    /**
     * Double click
     *
     * @param string $selector
     * @param string $button left|right|middle
     * @param int $delay btw clicks in milliseconds
     * @param array $modifiers ["Alt"|"Control"|"Meta"|"Shift"] or empty
     * @param bool $force Whether to bypass the actionability checks
     * @param int $timeout
     */
    public function dblclick(string $selector, string $button = 'left', int $delay = 0, array $modifiers = [], bool $force = false, int $timeout = 30000): void
    {
        $options = [
            'button' => $button,
            'delay' => $delay,
            'modifiers' => $modifiers,
            'force' => $force,
            'timeout' => $timeout,
        ];

        $builder = Functions::callAwaitSafe("$this->elementVarName.dblclick", $selector, $options);
        $this->merge($builder);
    }

    public function fill(string $selector, string $value, int $timeout = 30000): void
    {
        $options = [
            'timeout' => $timeout,
        ];

        $builder = Functions::callAwaitSafe("$this->elementVarName.fill", $selector, $value, $options);
        $this->merge($builder);
    }

    public function focus(string $selector, int $timeout = 30000): void
    {
        $options = [
            'timeout' => $timeout,
        ];

        $builder = Functions::callAwaitSafe("$this->elementVarName.focus", $selector, $options);
        $this->merge($builder);
    }

    /**
     * @param string $selector
     * @param string $customVarName
     * @param int $timeout
     */
    public function innerHTMLToVar(string $selector, string $customVarName, int $timeout = 30000): void
    {

        $options = [
            'timeout' => $timeout,
        ];

        $builder = Functions::callAwaitSafe("$this->elementVarName.innerHTML", $selector, $options);
        $builder->toVar($customVarName);
        $this->merge($builder);
    }

    /**
     * @param string $selector
     * @param string $customVarName
     * @param int $timeout
     */
    public function innerTextToVar(string $selector, string $customVarName, int $timeout = 30000): void
    {

        $options = [
            'timeout' => $timeout,
        ];

        $builder = Functions::callAwaitSafe("$this->elementVarName.innerText", $selector, $options);
        $builder->toVar($customVarName);
        $this->merge($builder);
    }

}
