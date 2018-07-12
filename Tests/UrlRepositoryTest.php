<?php namespace Tests;
/**
 * @author d.ivaschenko
 */

use App\Container;
use App\Models\Url;
use App\Repositories\UrlRepository;

require_once __DIR__ . '/TestCase.php';

class UrlRepositoryTest extends TestCase
{

    /**
     * @throws \ErrorException
     */
    public function testCreate()
    {
        $pdoMock = $this->createMock(\PDO::class);
        $urlModel = new Url();
        $urlModel->url = 'http://google.com';
        $urlModel->code = 'code1';

        $pdoStatementMock = $this->createMock(\PDOStatement::class);
        $pdoStatementMock->expects($this->once())->method('execute')->with([':url' => $urlModel->url, ':code' => $urlModel->code])->willReturn(true);
        $pdoMock->expects($this->once())->method('prepare')->with('INSERT INTO urls (url,code) VALUES (:url,:code)')->willReturn($pdoStatementMock);

        Container::instance(\PDO::class, $pdoMock);

        $urlRepository = new UrlRepository();
        $result = $urlRepository->create($urlModel);
        $this->assertTrue($result);
    }

    public function testGetOnBy()
    {
        $pdoStatementMock = $this->createMock(\PDOStatement::class);
        $pdoStatementMock->expects($this->once())->method('bindValue')->with(':val', 'code1', \PDO::PARAM_STR)->willReturn(true);
        $pdoStatementMock->expects($this->once())->method('setFetchMode');
        $pdoStatementMock->expects($this->once())->method('execute');
        $pdoStatementMock->expects($this->once())->method('fetch')->willReturn(true);

        $pdoMock = $this->createMock(\PDO::class);
        $pdoMock->expects($this->once())->method('prepare')->with('SELECT * FROM urls WHERE code = :val LIMIT 1')->willReturn($pdoStatementMock);

        Container::instance(\PDO::class, $pdoMock);

        $urlRepository = new UrlRepository();
        $result = $urlRepository->getOneBy('code', 'code1');
        $this->assertTrue($result);
    }

}