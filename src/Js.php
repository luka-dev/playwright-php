<?php

namespace PlayWrightClient;

use PlayWrightClient\Api\Context;
use PlayWrightClient\Exception\JsError;

class Js
{
    protected $jsString;
    private $jsVarNames = ['data'];

    private $blackListOfVarNames = [
        'require',
        'console',
        'throw',
        'new',
        'Error',
        'null',
        'NaN',
        'typeof',
        'eval',
        'func',
        'async',
        'await',
        'then',
        'catch',
        'undefined',
        'function',
        'Promise',
        'data',
        'Function',
    ];

    /**
     * JS constructor.
     * Here can be passed address of shared Js var storage
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
     * @return JS
     */
    final public function append(string $js, bool $needNewLine = true, bool $semicolon = true): JS
    {
        $this->jsString .= $js;
        if ($semicolon) {
            $this->jsString .= ';';
        }
        if ($needNewLine) {
            $this->jsString .= PHP_EOL;
        }
        return $this;
    }

    /**
     * Adding js to the beginning
     *
     * @param string $js
     * @param bool $needNewLine
     * @param bool $semicolon
     * @return JS
     */
    final public function prepend(string $js, bool $needNewLine = true, bool $semicolon = true): JS
    {
        if ($semicolon) {
            $js .= ';';
        }
        if ($needNewLine) {
            $js .= PHP_EOL;
        }
        $this->jsString = $js . $this->jsString;
        return $this;
    }

    public function tryCatch(JS $try, ?JS $catch): JS
    {
        if ($catch === null) {
            $catch = new JS();
        }
        /** @var $catch JS */

        $this->append('try {', true, false);
        $this->append($try->getJS());
        $this->append('} catch (e) {', true, false);
        $this->append($catch->getJS());
        $this->append('}', true, false);

        return $this;
    }

    /**
     * get simple JS as a string
     *
     * @return string
     */
    public function getJS(): string
    {
        return $this->jsString;
    }

    /**
     * Save any data to var
     *
     * @param string $varName
     * @param string $js
     * @param bool $semicolon
     * @return void
     * @throws JSError
     */
    final public function saveToVar(string $varName, string $js = '', bool $semicolon = true): void
    {
        if (in_array($varName, $this->blackListOfVarNames)) {
            throw new JsError('Bad var name (in blacklist)' . $varName);
        }

        if (!in_array(explode('.', $varName, 2)[0], $this->jsVarNames, true)) {
            $this->jsVarNames[] = $varName;
            $this->append('let ', false, false);
        }
        $this->append($varName . ' = ' . $js, false);

        if ($semicolon) {
            $this->append(';', false);
        }

    }

    final protected function deleteVar(string $varName): void
    {
        if (in_array($varName, $this->blackListOfVarNames)) {
            throw new JsError('Bad var name (in blacklist)' . $varName);
        }

        $this->append("delete $varName");

        $varNameIndex = array_search($varName, $this->jsVarNames, true);

        if ($varNameIndex !== null) {
            unset($this->jsVarNames[$varNameIndex]);
            $this->jsVarNames = array_values($this->jsVarNames);
        }
    }

    final protected function getVarsName(): array
    {
        return $this->jsVarNames;
    }

    final protected function safeAwaitAppend(string $js, bool $needNewLine = true, bool $semicolon = true): Js
    {
        $this->append('await modules.pss(' . $js . ')');
        return $this;
    }

    /**
     * php assoc array to js object
     * php plain array to js array
     *
     * @param array|string|int|float $params
     * @param bool $skipNull
     * @return string
     */
    final public static function build($params, bool $skipNull = false): string
    {
        if ($skipNull && is_array($params)) {
            array_filter($params, static function ($v) {
                return !is_null($v);
            });
        }

        return json_encode($params);
    }

    /**
     * build list from array
     * 'arg1', 'arg2', 'arg3'
     *
     * @param array $params
     * @return string
     */
    final public static function buildList(array $params): string
    {
        $paramEscaped = [];

        foreach ($params as $param) {
            $paramEscaped[] = '\'' . $param . '\'';
        }

        return implode(', ', $paramEscaped);
    }

    final public static function generateRandomVarName(): string
    {
        $characters = 'abcdefghijklmnopqrstuvwxyz';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < 10; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return 'temp' . time() . $randomString;
    }

}
