<?php


namespace PlayWrightClient\Js;


use PlayWrightClient\Exception\JsError;

final class Vars
{

    public function __construct()
    {
        throw new \RuntimeException("can't create an instance");
    }

    private static $varNames = [];

    private static $blacklistOfNames = [
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
        'Function',
    ];

    public static function validateVarName(string $varName): bool
    {
        if (in_array($varName, self::$blacklistOfNames)) {
            return is_int(preg_match('/^[a-zA-Z_$][0-9a-zA-Z_$]*$/', $varName));
        }
        return false;
    }

    public static function addPreDefinedVar(string $varName): void
    {
        if (self::validateVarName($varName)) {
            throw new JsError('invalid var name ' . $varName);
        }

        self::$varNames[] = $varName;
    }

    public static function clear(): void
    {
        self::$varNames = [];
    }

    public static function generateRandomVarName(): string
    {
        mt_srand(microtime());
        $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < 10; $i++) {
            $randomString .= $characters[random_int(0, $charactersLength - 1)];
        }
        return 'temp' . time() . $randomString;
    }

    /**
     * @param string $varName
     * @param Builder $data
     * @param string $varType let|var|const
     * @return void
     */
    public static function toVar(string $varName, Builder $data, string $varType = 'let'): void
    {
        if (self::validateVarName($varName)) {
            throw new JsError('invalid var name ' . $varName);
        }

        $data->prepend($varName . ' = (', false, false);
        $data->append(')', false, true);


        if (in_array($varName, self::$varNames, true)) {
            $data->prepend($varType . ' ', false, false);
        }
    }

    /**
     * @param Builder $data
     * @param string $varType  let|var|const
     * @return string temp var name
     */
    public static function toTempVar(Builder $data, string $varType = 'let'): string
    {
        $varName = self::generateRandomVarName();
        self::toVar($varName, $data, $varType);
        return $varName;
    }


}
