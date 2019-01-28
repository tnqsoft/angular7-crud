<?php

namespace Com\Tnqsoft\Providers;

use \Twig_Environment;
use Com\Tnqsoft\Helper\Twig;

// Apply Singleton design pattern
final class TwigProvider
{
    private static $instance;

    public static function getInstance(Twig_Environment &$twig)
    {
        if (static::$instance === null) {
            static::$instance = new Twig($twig);
        }

        return static::$instance;
    }

    private function __construct()
    {
    }

    private function __clone()
    {
    }

    private function __wakeup()
    {
    }
}
