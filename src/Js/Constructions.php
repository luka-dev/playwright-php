<?php


namespace PlayWrightClient\Js;


final class Constructions
{
    public function __construct()
    {
        throw new \RuntimeException("can't create an instance");
    }

    /**
     * php assoc array to js object
     * php plain array to js array
     *
     * @param array|string|int|float $params
     * @param bool $skipNull
     * @return string
     */
    public static function build($params, bool $skipNull = false): string
    {
        if ($skipNull && is_array($params)) {
            $params = array_filter($params, static function ($value) {
                return !is_null($value);
            });
        }

        return json_encode($params);
    }


    public static function tryCatch(Script $try, ?Script $catch, string $errorVarName = 'e'): Script
    {
        if ($catch === null) {
            $catch = new Script();
        }
        /** @var $catch Script */

        $tryCatch = new Script();

        $tryCatch->append('try {', true, false);
        $tryCatch->append($try->getJs());
        $tryCatch->append("} catch ($errorVarName) {", true, false);
        $tryCatch->append($catch->getJs());
        $tryCatch->append('}', true, false);

        return $tryCatch;
    }

    public static function ifElse(Script $if, ?Script $else): Script
    {

    }

    //todo make cycle (for / foreach)


}
