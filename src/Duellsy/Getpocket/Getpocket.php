<?php namespace Duellsy\Getpocket;

use Guzzle\Http\Client;

/**
 * The Getpocket package is a quick wrap to make connecting and
 * consuming the pocket API much simpler and quicker to get up and running.
 * For information / documentation on using this package, please refer to:
 * https://github.com/duellsy/getpocket
 *
 * @package    Getpocket
 * @version    1.0
 * @author     Chris Duell
 * @license    MIT
 * @copyright  (c) 2013 Chris Duell
 * @link       https://github.com/duellsy/getpocket
 */
class Getpocket
{

    const BASE_URL = 'https://getpocket.com';

    public function getBaseUrl()
    {
        return self::BASE_URL;
    }


    /**
     * Get the initial request token to kick off the OAuth process
     *
     * @param  string $consumer_key
     */
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



    /**
     * Get a list of active bookmarks from the API
     *
     * @param  string $consumer_key
     * @param  string $access_token
     */
    public function retrieve($consumer_key, $access_token, $options = array())
    {

        $params = array(
            'consumer_key'  => $consumer_key,
            'access_token'  => $access_token
        );

        // combine the creds with any options sent
        $params = array_merge($params, $options);

        $client = new Client(self::BASE_URL);
        $request = $client->post('/v3/get');
        $request->getParams()->set('redirect.strict', true);
        $request->setHeader('Content-Type', 'application/json; charset=UTF8');
        $request->setHeader('X-Accept', 'application/json');
        $request->setBody(json_encode($params));
        $response = $request->send();

        return json_decode($response->getBody());

    }



    /**
     * Responsible for sending the request to the pocket API
     *
     * @param  string $consumer_key
     * @param  string $access_token
     * @param  array $actions
     */
    public function send($consumer_key, $access_token, $actions)
    {

        $actions = json_encode($actions);
        $actions = urlencode($actions);

        $client = new Client(self::BASE_URL);
        $request = $client->get(
            '/v3/send?actions=' . $actions .
            '&consumer_key=' . $consumer_key .
            '&access_token=' . $access_token
        );

        $response = $request->send();

        return json_decode($response->getBody());

    }




    /**
     * All single actions are routed through this method,
     * to wrap the request in the required format for the
     * pocket API.
     *
     * Valid actions are: favorite, unfavorite, archive, readd, delete
     *
     * @param  string $consumer_key
     * @param  string $access_token
     * @param  int $item_id
     * @param  string $action
     */
    public function sendSingle($consumer_key, $access_token, $item_id, $action)
    {

        $actions = array(
            array(
                'action'        => $action,
                'item_id'       => $item_id
            )
        );

        return self::send($consumer_key, $access_token, $actions);

    }


    /**
     * Mark as bookmark as a favorite
     *
     * @param  string $consumer_key
     * @param  string $access_token
     * @param  int $item_id
     */
    public function favorite($consumer_key, $access_token, $item_id)
    {
        return self::sendSingle($consumer_key, $access_token, $item_id, 'favorite');
    }

    /**
     * Unmark as bookmark as a favorite
     *
     * @param  string $consumer_key
     * @param  string $access_token
     * @param  int $item_id
     */
    public function unfavorite($consumer_key, $access_token, $item_id)
    {
        return self::sendSingle($consumer_key, $access_token, $item_id, 'unfavorite');
    }


    /**
     * Remove a particular bookmark
     *
     * @param  string $consumer_key
     * @param  string $access_token
     * @param  int $item_id
     */
    public function delete($consumer_key, $access_token, $item_id)
    {
        return self::sendSingle($consumer_key, $access_token, $item_id, 'delete');
    }


    /**
     * Archive a particular bookmark
     *
     * @param  string $consumer_key
     * @param  string $access_token
     * @param  int $item_id
     */
    public function archive($consumer_key, $access_token, $item_id)
    {
        return self::sendSingle($consumer_key, $access_token, $item_id, 'archive');
    }


    /**
     * Re-add a bookmark that was previously archived
     *
     * @param  string $consumer_key
     * @param  string $access_token
     * @param  int $item_id
     */
    public function readd($consumer_key, $access_token, $item_id)
    {
        return self::sendSingle($consumer_key, $access_token, $item_id, 'readd');
    }



}
