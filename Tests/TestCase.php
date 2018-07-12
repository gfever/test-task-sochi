<?php namespace Tests;
/**
 * @author d.ivaschenko
 */


class TestCase extends \PHPUnit\Framework\TestCase
{
    public function setUp()
    {
        parent::setUp();
        require_once __DIR__ . '/../Autoloader.php';
        require_once __DIR__ . '/../vendor/autoload.php';
    }
}