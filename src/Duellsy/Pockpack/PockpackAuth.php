<?php namespace Duellsy\Pockpack;

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
class PockpackAuth extends PockpackBase
{
    
    /**
     * Get the initial request token to kick off the OAuth process
     *
     * @param  string $consumer_key
     */
    public function connect($consumer_key)
    {
        $params = array(
            'consumer_key'  => $consumer_key,
            'redirect_uri'  => '.'
        );

        $request = $this->getClient()->post('/v3/oauth/request');
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
        $pocketData = $this->convertRequestToken($consumer_key, $request_token);

        $access_token = $pocketData->access_token;

        return $access_token;
    }

    /**
     * Grab an access token and the username from the pocket API, after sending it
     * the consumer key and request token from earlier
     *
     * @param  string $consumer_key
     * @param  string $request_token
     */
    public function receiveTokenAndUsername($consumer_key, $request_token)
    {
        $pocketData = $this->convertRequestToken($consumer_key, $request_token);

        $returnData['access_token'] = $pocketData->access_token;
        $returnData['username'] = $pocketData->username;
        
        return $returnData;
    }

    /**
     * Convert a request token into a Pocket access token. 
     * We also get the username in the same response from Pocket.
     * 
     * @param  string $consumer_key
     * @param  string $request_token
     */
    private function convertRequestToken($consumer_key, $request_token)
    {
        $params = array(
            'consumer_key'  => $consumer_key,
            'code'  => $request_token
        );

        $request = $this->getClient()->post('/v3/oauth/authorize');
        $request->getParams()->set('redirect.strict', true);
        $request->setHeader('Content-Type', 'application/json; charset=UTF8');
        $request->setHeader('X-Accept', 'application/json');
        $request->setBody(json_encode($params));
        $response = $request->send();

        $data = json_decode($response->getBody());

        return $data;
    }

}
