<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit84b87bc091ac7bf99eb8d68af7e1e87d
{
    public static $files = array (
        '5255c38a0faeba867671b61dfda6d864' => __DIR__ . '/..' . '/paragonie/random_compat/lib/random.php',
        '72579e7bd17821bb1321b87411366eae' => __DIR__ . '/..' . '/illuminate/support/helpers.php',
        'c7a1089ba35f8274cf630debb7de059c' => __DIR__ . '/..' . '/ezimuel/php-secure-session/bin/register_secure_session.php',
    );

    public static $prefixLengthsPsr4 = array (
        'P' => 
        array (
            'PHPSecureSession\\' => 17,
        ),
        'I' => 
        array (
            'Illuminate\\Support\\' => 19,
            'Illuminate\\Contracts\\' => 21,
        ),
        'A' => 
        array (
            'Adldap\\' => 7,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'PHPSecureSession\\' => 
        array (
            0 => __DIR__ . '/..' . '/ezimuel/php-secure-session/src',
        ),
        'Illuminate\\Support\\' => 
        array (
            0 => __DIR__ . '/..' . '/illuminate/support',
        ),
        'Illuminate\\Contracts\\' => 
        array (
            0 => __DIR__ . '/..' . '/illuminate/contracts',
        ),
        'Adldap\\' => 
        array (
            0 => __DIR__ . '/..' . '/adldap2/adldap2/src',
        ),
    );

    public static $prefixesPsr0 = array (
        'D' => 
        array (
            'Doctrine\\Common\\Inflector\\' => 
            array (
                0 => __DIR__ . '/..' . '/doctrine/inflector/lib',
            ),
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit84b87bc091ac7bf99eb8d68af7e1e87d::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit84b87bc091ac7bf99eb8d68af7e1e87d::$prefixDirsPsr4;
            $loader->prefixesPsr0 = ComposerStaticInit84b87bc091ac7bf99eb8d68af7e1e87d::$prefixesPsr0;

        }, null, ClassLoader::class);
    }
}
