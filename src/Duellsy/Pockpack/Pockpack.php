<?php namespace Duellsy\Pockpack;

use Duellsy\Pockpack\NoPockpackQueueException;

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
class Pockpack extends PockpackBase
{
    private $consumer_key;
    private $access_token;

    public function __construct($consumer_key, $access_token)
    {
        $this->consumer_key = $consumer_key;
        $this->access_token = $access_token;
    }

    /**
     * Responsible for sending the request to the pocket API
     *
     * @param  string $consumer_key
     * @param  string $access_token
     * @param  array $actions
     */
    public function send(PockpackQueue $queue = null)
    {
        if( is_null($queue) ) {
            throw new NoPockpackQueueException();
        }

        $params = array(
            'actions'       => json_encode($queue->getActions()),
            'consumer_key'  => $this->consumer_key,
            'access_token'  => $this->access_token
        );

        $request = $this->getClient()->get('/v3/send');
        $request->getQuery()->merge($params);

        $response = $request->send();

        // remove any items from the queue
        $queue->clear();

        return json_decode($response->getBody());
    }

    /**
     * Retrieve the data from the pocket API
     *
     * @param array   $options options to filter the data
     * @param boolean $isArray if decode JSON to array
     *
     * @return array
     */
    public function retrieve($options = array(), $isArray = false)
    {
        $params = array(
            'consumer_key'  => $this->consumer_key,
            'access_token'  => $this->access_token
        );

        // combine the creds with any options sent
        $params = array_merge($params, $options);

        $request = $this->getClient()->post('/v3/get');
        $request->getParams()->set('redirect.strict', true);
        $request->setHeader('Content-Type', 'application/json; charset=UTF8');
        $request->setHeader('X-Accept', 'application/json');
        $request->setBody(json_encode($params));
        $response = $request->send();

        return json_decode($response->getBody(), $isArray);
    }

}
