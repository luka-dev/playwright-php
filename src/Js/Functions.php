<?php


namespace PlayWrightClient\Js;


final class Functions
{

    public function __construct()
    {
        throw new \RuntimeException("can't create an instance");
    }

    /**
     * @param array $args
     * @return string
     */
    private static function buildArgs(array $args): string
    {
        $buildedArgs = [];

        foreach ($args as $arg) {
            $buildedArgs[] = Constructions::build($arg);
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

        $buildedArgs = self::buildArgs($args);

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

    /**
     * RECOMMENDED
     * this call, in case error, can be catched by simple try->catch
     *
     * @param string $funcName
     * @param mixed ...$args
     * @return Builder
     */
    public static function callAwaitSafe(string $funcName, ...$args): Builder
    {
        $builder = self::call($funcName, ...$args);
        $builder->wrapInFunction('modules.pss');
        $builder->prepend(' ', false, false);
        $builder->prepend('await', false, false);
        return $builder;
    }


}
