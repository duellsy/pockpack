<?php namespace Duellsy\Getpocket;

use Guzzle\Http\Client;
use Guzzle\Http\Message\RequestFactory;

class Getpocket
{

    const BASE_URL = 'http://getpocket.com';

    public function connect($consumer_key)
    {

        $params = array(
            'consumer_key'  => $consumer_key,
            'redirect_uri'  => \URL::to('pocket/receiveToken')
        );

        $client = new Client(self::BASE_URL);
        $request = $client->post('/v3/oauth/request');
        $request->getParams()->set('redirect.strict', true);
        $request->setHeader('Content-Type', 'application/json');
        $request->setHeader('X-Accept', 'application/json');
        $request->setBody(json_encode($params));
        $response = $request->send();

// $factory = new RequestFactory();
// $request = $factory->fromMessage(
//     "POST /v3/oauth/request HTTP/1.1\r\n" .
//     "Host: getpocket.com\r\n" .
//     "Content-Type: application/json; charset=UTF-8\r\n" .
//     "X-Accept: application/json\r\n\r\n" .
//     json_encode($params)
// );

// $response = $request->send();

        var_dump($params);
        var_dump($response);

    }


    public function receiveToken()
    {

        $data = json_decode(file_get_contents("php://input"));

        var_dump($data);

    }

}
