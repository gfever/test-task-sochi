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

    public function create(string $url)
    {
        if (empty($url)) {
            throw new \Exception('Url param required!');
        }

        $urlModel = new Url();
        $urlModel->url = $url;

        $repository = new UrlRepository();
        $exist = true;
        $helper = new Helper();
        while ($exist) {
            $code = $helper->generateRandomString();
            $exist = $repository->getOneBy('code', $code);
        }

        $urlModel->code = $code;
        $repository->create($urlModel);

        return (new Response())->sendJson(json_encode(['short_url' => $helper->siteURL() . $urlModel->code]));
    }

    public function redirect(string $code)
    {
        $repository = new UrlRepository();
        $url = $repository->getOneBy('code', $code);
        (new Response())->redirect($url);
    }

}