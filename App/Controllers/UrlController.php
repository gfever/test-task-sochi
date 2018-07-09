<?php
/**
 * @author d.ivaschenko
 */

namespace App\Controllers;


use App\Helpers\Helper;
use App\Models\Url;
use App\Repositories\UrlRepository;
use App\Response;

class UrlController
{
    public function index()
    {
        echo file_get_contents(__DIR__ . '/../../views/index.html');
    }

    /**
     * @param string $url
     * @throws \ErrorException
     */
    public function create(): void
    {
        $url = $_POST['url'];
        if (empty($url) || filter_var($url, FILTER_VALIDATE_URL) === false) {
            throw new \InvalidArgumentException('Invalid url!');
        }

        $repository = new UrlRepository();
        $helper = new Helper();
        $urlModel = $repository->getOneBy('url', $url);

        if (!$urlModel instanceof Url) {
            $urlModel = new Url();
            $urlModel->url = $url;

            $codeExist = true;

            while ($codeExist) {
                $code = $helper->generateRandomString();
                $codeExist = $repository->getOneBy('code', $code);
            }

            $urlModel->code = $code;
            $repository->create($urlModel);
        }

        (new Response())->sendString($helper->siteURL() . $urlModel->code);
    }


    /**
     * @throws \Exception
     */
    public function redirect(): void
    {
        $code = (new Helper())->getUri();
        if (empty($code)) {
            throw new \InvalidArgumentException('Code can\'t be empty');
        }
        $repository = new UrlRepository();
        $url = $repository->getOneBy('code', $code);
        if (empty($url)) {
            throw new \Exception('Url not found', 404);
        }

        (new Response())->redirect($url->url);
    }

}