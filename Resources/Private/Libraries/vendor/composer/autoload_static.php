<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit29dd4607ecd88364699523e495d0cfa1
{
    public static $prefixesPsr0 = array (
        'S' => 
        array (
            'SimplePie' => 
            array (
                0 => __DIR__ . '/..' . '/simplepie/simplepie/library',
            ),
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixesPsr0 = ComposerStaticInit29dd4607ecd88364699523e495d0cfa1::$prefixesPsr0;

        }, null, ClassLoader::class);
    }
}
