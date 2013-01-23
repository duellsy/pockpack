<?php namespace Duellsy\Getpocket;

use Guzzle\Http\Client;

class Getpocket
{

    const BASE_URL = 'https://getpocket.com';

    public function getBaseUrl()
    {
        return self::BASE_URL;
    }

    public function connect($consumer_key)
    {

        $params = array(
            'consumer_key'  => $consumer_key,
            'redirect_uri'  => \URL::to('pocket/receiveToken')
        );

        $client = new Client(self::BASE_URL);
        $request = $client->post('/v3/oauth/request');
        $request->getParams()->set('redirect.strict', true);
        $request->setHeader('Content-Type', 'application/json; charset=UTF8');
        $request->setHeader('X-Accept', 'application/json');
        $request->setBody(json_encode($params));
        $response = $request->send();

        $data = json_decode($response->getBody());

        $request_token = $data->code;

        return $request_token;
    }


    public function receiveToken($consumer_key, $request_token)
    {

        $params = array(
            'consumer_key'  => $consumer_key,
            'code'  => $request_token
        );

        $client = new Client(self::BASE_URL);
        $request = $client->post('/v3/oauth/authorize');
        $request->getParams()->set('redirect.strict', true);
        $request->setHeader('Content-Type', 'application/json; charset=UTF8');
        $request->setHeader('X-Accept', 'application/json');
        $request->setBody(json_encode($params));
        $response = $request->send();

        $data = json_decode($response->getBody());

        $access_token = $data->access_token;

        return $access_token;

    }

    public function retrieve($consumer_key, $access_token)
    {

        $params = array(
            'consumer_key'  => $consumer_key,
            'access_token'  => $access_token,
            'detailType'    => 'complete'
        );

        $client = new Client(self::BASE_URL);
        $request = $client->post('/v3/get');
        $request->getParams()->set('redirect.strict', true);
        $request->setHeader('Content-Type', 'application/json; charset=UTF8');
        $request->setHeader('X-Accept', 'application/json');
        $request->setBody(json_encode($params));
        $response = $request->send();

        return json_decode($response->getBody());

    }



}
