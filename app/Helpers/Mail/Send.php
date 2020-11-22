<?php

namespace App\Helpers\Mail;

use GuzzleHttp\Client;
use function GuzzleHttp\Psr7\build_query;

class Send
{
    public static function request(string $send_to, string $message)
    {
        $method = 'GET';
        $url = config('constants.mail.url');
        $password = config('constants.mail.password');
        $login = config('constants.mail.login');

        $params = [
            'login' => $login,
            'psw' => $password,
            'phones' => $send_to,
            'fmt' => 3,
            'mes' => $message,
        ];

        $client = new Client();

        $response = $client->request('GET', $url, ['query' => $params]);

        $response = $response->getBody()->getContents();
        return $response;

    }
}
