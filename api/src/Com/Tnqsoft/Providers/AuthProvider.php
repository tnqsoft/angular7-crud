<?php

namespace Com\Tnqsoft\Providers;

use Com\Tnqsoft\Helper\Auth;

// Apply Singleton design pattern
final class AuthProvider
{
    private static $instance;

    public static function getInstance()
    {
        if (static::$instance === null) {
            static::$instance = new Auth();
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
