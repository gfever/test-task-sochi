<?php
/**
 * @author d.ivaschenko
 */

namespace App;

/**
 * Class Container
 * @package App
 */
class Container
{

    private static $instances = [];

    /**
     * @param string $className
     * @return mixed
     */
    public static function make(string $className)
    {
        return self::$instances[$className] ?? new $className;
    }

    /**
     * @param string $className
     * @param $instance
     */
    public static function instance(string $className, $instance): void
    {
        self::$instances[$className] = $instance;
    }

    /**
     * @param string $className
     * @return bool
     */
    public static function isInstanced(string $className): bool
    {
        return isset(self::$instances[$className]);
    }
}