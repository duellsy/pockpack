<?php namespace Duellsy\Pockpack;

use Guzzle\Http\Client;
use Duellsy\Pockpack\NoConsumerKeyException;
/**
 * The Pockpack package is a quick wrap to make connecting and
 * consuming the pocket API much simpler and quicker to get up and running.
 * For information / documentation on using this package, please refer to:
 * https://github.com/duellsy/pockpack
 *
 * @package    Pockpack
 * @version    2.0.0
 * @author     Chris Duell
 * @license    MIT
 * @copyright  (c) 2013 Chris Duell
 * @link       https://github.com/duellsy/pockpack
 */
class PockpackAuth
{

    const BASE_URL = 'https://getpocket.com';

    /**
     * Give external access to the base URL
     */
    public function getBaseUrl()
    {
        return self::BASE_URL;
    }



    /**
     * Get the initial request token to kick off the OAuth process
     *
     * @param  string $consumer_key
     */
    public function connect($consumer_key = null)
    {

        if( is_null($consumer_key) OR $consumer_key == '') {
            throw new NoConsumerKeyException("No consumer key given when connecting via PockpackAuth");
        }

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



    /**
     * Grab an access token from the pocket API, after sending it
     * the consumer key and request token from earlier
     *
     * @param  string $consumer_key
     * @param  string $request_token
     */
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



}
