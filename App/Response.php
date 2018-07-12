<?php
/**
 * @author d.ivaschenko
 */

namespace App;

/**
 * Class Response
 * @package App
 *
 */
class Response
{
    /**
     * @param string $message
     * @param int $code
     * @return array
     */
    public  function sendString(string $message, int $code = 200): array
    {
        return [
            'headers' => [
                'Status' => ['200 OK', $code]
            ],
            'message' => $message
        ];
    }

    /**
     * @param string $url
     * @return array
     */
    public  function redirect(string $url): array
    {
        return [
            'headers' => [
                'Location' => [$url, 301]
            ],
            'message' => ''
        ];
    }
}