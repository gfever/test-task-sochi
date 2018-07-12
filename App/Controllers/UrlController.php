<?php
/**
 * @author d.ivaschenko
 */

namespace App\Controllers;


use App\Container;
use App\Helpers\Helper;
use App\Models\Url;
use App\Repositories\UrlRepository;
use App\Response;

class UrlController
{
    /**
     * @return array
     */
    public function index(): array
    {
        return (new Response())->sendString(file_get_contents(__DIR__ . '/../../views/index.html'));
    }

    /**
     * @return array
     * @throws \ErrorException
     */
    public function create(): array
    {
        $url = $_POST['url'];
        if (empty($url) || filter_var($url, FILTER_VALIDATE_URL) === false) {
            throw new \InvalidArgumentException('Invalid url!');
        }

        /** @var UrlRepository $repository */
        $repository = Container::make(UrlRepository::class);
        $helper = Container::make(Helper::class);
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

        return (new Response())->sendString($helper->siteURL() . $urlModel->code);
    }


    /**
     * @throws \Exception
     */
    public function redirect(): array
    {
        $code = Container::make(Helper::class)->getUri();
        if (empty($code)) {
            throw new \InvalidArgumentException('Code can\'t be empty');
        }
        $repository = Container::make(UrlRepository::class);
        $url = $repository->getOneBy('code', $code);
        if (empty($url)) {
            throw new \Exception('Url not found', 404);
        }

        return (new Response())->redirect($url->url);
    }

}