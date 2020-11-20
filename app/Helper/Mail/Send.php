<?php

namespace App\Helper\Mail;

use GuzzleHttp\Client;

class Send
{
    public static function request(int $user_id, array $params)
    {
        $method = 'GET';
        $url = config('constants.mail.url');
        $password = config('constants.mail.password');
        $login = config('constants.mail.login');
        $params['psw'] = $password;
        $params['login'] = $login;
        $params['fmt'] = 3;


        $client = new Client();
        $response = $client->request($method, $url, [
            $params
        ]);



    }
}
