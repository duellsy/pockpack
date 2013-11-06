<?php

use Guzzle\Plugin\Mock\MockPlugin;
use Guzzle\Http\Message\Response;

class PocketTest extends PHPUnit_Framework_TestCase
{
    private $pockpack;

    public function setUp()
    {
        $this->pockpack = new Duellsy\Pockpack\Pockpack('fake_consumer_key', 'fake_access_token');
    }

    /**
     * @expectedException Guzzle\Http\Exception\ClientErrorResponseException
     */
    public function testSimpleMocking()
    {
        $this->setPocketResponse(new Response(404));

        $this->pockpack->retrieve();
    }

    /**
     * Convieniece method to quickly mock the response from Pocket
     * 
     * @param  Response $response
     */
    private function setPocketResponse($response)
    {
        $mock = new MockPlugin();
        $mock->addResponse($response);

        $this->pockpack->getClient()->addSubscriber($mock);
    }
}
