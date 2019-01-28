<?php

namespace Com\Tnqsoft\Providers;

use Com\Tnqsoft\Helper\DBAccess;

// Apply Singleton design pattern
final class DatabaseProvider
{
    private static $instance;

    public static function getInstance()
    {
        if (static::$instance === null) {
            static::$instance = new DBAccess();
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
