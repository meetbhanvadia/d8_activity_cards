<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitc304e8fddb615073ee304564583dfdf0
{
    public static $fallbackDirsPsr0 = array (
        0 => __DIR__ . '/..' . '/guhelski/forecast-php/src',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->fallbackDirsPsr0 = ComposerStaticInitc304e8fddb615073ee304564583dfdf0::$fallbackDirsPsr0;

        }, null, ClassLoader::class);
    }
}
