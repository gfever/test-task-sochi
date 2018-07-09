<?php namespace Tests;
use App\Controllers\UrlController;
use PHPUnit\Framework\TestCase;

/**
 * @author d.ivaschenko
 */


class UrlControllerTest extends TestCase
{
    /** @var UrlController */
    public $controller;

    public function setUp()
    {
        parent::setUp();
        $this->controller = new UrlController();
    }

    public function testIndex()
    {
        $this->assertEquals($this->controller->index(), file_get_contents(__DIR__ . '/../views/index.html'));
    }
}