<?php
/**
 * Simple autoloader, so we don't need Composer just for this.
 */
class Autoloader
{
    public static function register()
    {
        spl_autoload_register(function ($class) {
            $file = str_replace('\\', DIRECTORY_SEPARATOR, $class) . '.php';
            if (file_exists(__DIR__ . '/' . $file)) {
                require_once __DIR__ . '/' . $file;
                return true;
            }
            return false;
        });
    }
}