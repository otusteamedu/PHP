<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit0835a810bcf4ae862a26d62c3953c11c
{
    public static $prefixLengthsPsr4 = array (
        'C' => 
        array (
            'Controllers\\' => 12,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Controllers\\' => 
        array (
            0 => __DIR__ . '/../..' . '/controllers',
        ),
    );

    public static $prefixesPsr0 = array (
        'B' => 
        array (
            'Bramus' => 
            array (
                0 => __DIR__ . '/..' . '/bramus/router/src',
            ),
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit0835a810bcf4ae862a26d62c3953c11c::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit0835a810bcf4ae862a26d62c3953c11c::$prefixDirsPsr4;
            $loader->prefixesPsr0 = ComposerStaticInit0835a810bcf4ae862a26d62c3953c11c::$prefixesPsr0;
            $loader->classMap = ComposerStaticInit0835a810bcf4ae862a26d62c3953c11c::$classMap;

        }, null, ClassLoader::class);
    }
}
