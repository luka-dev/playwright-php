<?php


namespace PlayWrightClient\Api;


use PlayWrightClient\Api\Structures\SelectOption;
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
    public function uncheck(string $selector, int $timeout = 30000): void
    {

        $options = [
            'timeout' => $timeout,
        ];

        $this->addToTimeout($timeout);

        $builder = Functions::callAwaitSafe("$this->elementVarName.uncheck", $selector, $options);
        $this->merge($builder);
    }

    /**
     * @param string $selector
     * @param int $timeout
     */
    public function check(string $selector, int $timeout = 30000): void
    {

        $options = [
            'timeout' => $timeout,
        ];

        $this->addToTimeout($timeout);

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

        $this->addToTimeout($timeout);

        $builder = Functions::callAwaitSafe("$this->elementVarName.dblclick", $selector, $options);
        $this->merge($builder);
    }

    public function fill(string $selector, string $value, int $timeout = 30000): void
    {
        $options = [
            'timeout' => $timeout,
        ];

        $this->addToTimeout($timeout);


        $builder = Functions::callAwaitSafe("$this->elementVarName.fill", $selector, $value, $options);
        $this->merge($builder);
    }

    public function focus(string $selector, int $timeout = 30000): void
    {
        $options = [
            'timeout' => $timeout,
        ];

        $this->addToTimeout($timeout);


        $builder = Functions::callAwaitSafe("$this->elementVarName.focus", $selector, $options);
        $this->merge($builder);
    }

    /**
     * @param string $selector
     * @param string $name
     * @param string $varName
     */
    public function getAttributeToVar(string $selector, string $name, string $varName): void
    {
        $builder = Functions::callAwaitSafe("$this->elementVarName.getAttribute", $selector, $name);
        $builder->toVar($varName);

        $this->merge($builder);
    }

    /**
     * @param string $selector
     * @param string[] $modifiers <Array<"Alt"|"Control"|"Meta"|"Shift">>
     * @param bool $force
     * @param int $timeout
     */
    public function hover(string $selector, array $modifiers = [], bool $force = false, int $timeout = 30000): void
    {

        $options = [
            'modifiers' => $modifiers,
            'force' => $force,
            'timeout' => $timeout,
        ];

        $this->addToTimeout($timeout);

        $builder = Functions::callAwaitSafe("$this->elementVarName.hover", $selector, $options);
        $this->merge($builder);
    }

    /**
     * Focuses the element, and then uses keyboard.down and keyboard.up.
     * @param string $key ArrowLeft or a
     * @param int $delay
     * @param int $timeout
     */
    public function press(string $key, int $delay = 0, int $timeout = 30000): void
    {
        $options = [
            'delay' => $delay,
            'timeout' => $timeout,
        ];

        $this->addToTimeout($timeout);

        $builder = Functions::callAwaitSafe("$this->elementVarName.press", $key, $options);
        $this->merge($builder);
    }


    public function scrollIntoViewIfNeeded(int $timeout = 30000): void
    {
        $options = [
            'timeout' => $timeout,
        ];

        $this->addToTimeout($timeout);

        $builder = Functions::callAwaitSafe("$this->elementVarName.scrollIntoViewIfNeeded", $options);
        $this->merge($builder);
    }

    /**
     * @param string $selector
     * @param SelectOption $value
     */
    public function selectOption(string $selector, SelectOption $value): void
    {
        $this->selectOptions($selector, [$value]);
    }

    /**
     * @param string $selector
     * @param SelectOption[] $values
     */
    public function selectOptions(string $selector, array $values): void
    {

        $valuesSerialized = [];

        foreach ($values as $value) {
            $valuesSerialized[] = $value->toArray();
        }

        $builder = Functions::callAwaitSafe("$this->elementVarName.selectOption", $selector, ...$valuesSerialized);
        $this->merge($builder);
    }

    public function selectText(int $timeout = 30000): void
    {
        $options = [
            'timeout' => $timeout,
        ];

        $this->addToTimeout($timeout);

        $builder = Functions::callAwaitSafe("$this->elementVarName.selectText", $options);
        $this->merge($builder);
    }

    /**
     * @param string $varName
     */
    public function textContentToVar(string $varName): void
    {
        $builder = Functions::callAwaitSafe("$this->elementVarName.textContent");
        $builder->toVar($varName);
        $this->merge($builder);
    }

    /**
     * @param string $text
     * @param int $delay
     * @param int $timeout
     */
    public function type(string $text, int $delay = 0, int $timeout = 30000): void
    {
        $options = [
            'delay' => $delay,
            'timeout' => $timeout,
        ];

        $this->addToTimeout($timeout);

        $builder = Functions::callAwaitSafe("$this->elementVarName.type", $text, $options);
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

        $this->addToTimeout($timeout);

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

        $this->addToTimeout($timeout);

        $builder = Functions::callAwaitSafe("$this->elementVarName.innerText", $selector, $options);
        $builder->toVar($customVarName);
        $this->merge($builder);
    }

}
