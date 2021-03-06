<?php


namespace PlayWrightClient\Js;


use PlayWrightClient\Api\Structures\NativeValue;

final class Functions
{

    public function __construct()
    {
        throw new \RuntimeException("can't create an instance");
    }

    /**
     * @param array $args
     * @param bool $skipNull
     * @return string
     */
    private static function buildArgs(array $args, bool $skipNull = false): string
    {
        $buildedArgs = [];

        foreach ($args as $arg) {
            if ($arg instanceof NativeValue) {
                $buildedArgs[] = $arg->getData();
            } else {
                $buildedArgs[] = Constructions::build($arg, $skipNull);
            }
        }

        return implode(',', $buildedArgs);
    }

    /**
     * @param string $funcName
     * @param mixed ...$args any arguments
     * @return Builder
     */
    public static function call(string $funcName, ...$args): Builder
    {
        $builder = new Builder();

        $buildedArgs = self::buildArgs($args, true);

        $builder->append($funcName . '(' . $buildedArgs . ')', false, false);

        return $builder;
    }

    public static function callAwait(string $funcName, ...$args): Builder
    {
        $builder = self::call($funcName, ...$args);
        $builder->prepend(' ', false, false);
        $builder->prepend('await', false, false);
        return $builder;
    }

//    /**
//     * RECOMMENDED
//     * this call, in case error, can be catched by simple try->catch
//     *
//     * @param string $funcName
//     * @param mixed ...$args
//     * @return Builder
//     */
//    public static function callAwaitSafe(string $funcName, ...$args): Builder
//    {
//        $builder = self::call($funcName, ...$args);
//        $builder->wrapInFunction('modules.pss');
//        $builder->prepend(' ', false, false);
//        $builder->prepend('await', false, false);
//        return $builder;
//    }


}
