<?php namespace Duellsy\Pockpack;

use Guzzle\Http\Client;

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
abstract class PockpackBase
{
    const BASE_URL = 'https://getpocket.com';

    private $client;

    /**
     * Give external access to the base URL
     */
    public function getBaseUrl()
    {
        return self::BASE_URL;
    }
    
    /**
     * Get the client used to query Pocket.
     *
     * @return  Client HTTP Client used to communicate with Pocket
     */
    public function getClient()
    {
        if ( $this->client ) {
            return $this->client;
        }

        $this->client = new Client(self::BASE_URL);

        return $this->client;
    }
}
