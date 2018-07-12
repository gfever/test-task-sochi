<?php namespace Tests;

require_once __DIR__ . '/TestCase.php';

use App\Container;
use App\Controllers\UrlController;
use App\Helpers\Helper;
use App\Models\Url;
use App\Repositories\UrlRepository;

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

    public function testIndex(): void
    {
        $this->assertEquals($this->controller->index()['message'], file_get_contents(__DIR__ . '/../views/index.html'));
    }

    /**
     * @throws \ErrorException
     */
    public function testCreate(): void
    {
        $urlRepositoryMock = $this->createMock(UrlRepository::class);
        $urlRepositoryMock->expects($this->at(0))->method('getOneBy')->willReturn(false);
        $urlRepositoryMock->expects($this->at(1))->method('getOneBy')->willReturn(false);
        $urlRepositoryMock->expects($this->at(2))->method('create');

        $helperMock = $this->createMock(Helper::class);
        $helperMock->expects($this->once())->method('generateRandomString')->willReturn('11111');
        $helperMock->expects($this->once())->method('siteURL')->willReturn('http://bit.ly/');

        Container::instance(UrlRepository::class, $urlRepositoryMock);
        Container::instance(Helper::class, $helperMock);
        $_POST['url'] = 'http://google.com';
        $result = $this->controller->create();

        $expected = [
            'headers' => [
                'Status' => ['200 OK', 200]
            ],
            'message' => 'http://bit.ly/11111'
        ];

        $this->assertEquals($expected, $result);
    }

    /**
     * @throws \Exception
     */
    public function testRedirect(): void
    {
        $urlModel = new Url();
        $urlModel->url = 'http://google.com';

        $urlRepositoryMock = $this->createMock(UrlRepository::class);
        $urlRepositoryMock->expects($this->once())->method('getOneBy')->willReturn($urlModel);

        $helperMock = $this->createMock(Helper::class);
        $helperMock->expects($this->once())->method('getUri')->willReturn('11111');

        Container::instance(UrlRepository::class, $urlRepositoryMock);
        Container::instance(Helper::class, $helperMock);

        $result = $this->controller->redirect();

        $expected = [
            'headers' => [
                'Location' => [$urlModel->url, 301]
            ],
            'message' => ''
        ];

        $this->assertEquals($expected, $result);
    }
}