<?php

use Guzzle\Plugin\Mock\MockPlugin;
use Guzzle\Http\Message\Response;

class PocketAuthTest extends PHPUnit_Framework_TestCase
{
    private $pockpack_auth;

    public function setUp()
    {
        $this->pockpack_auth = new Duellsy\Pockpack\PockpackAuth;
    }

    /**
     * @expectedException Guzzle\Http\Exception\ClientErrorResponseException
     */
    public function testSimpleMocking()
    {
        $this->setPocketResponse(new Response(404));

        $this->pockpack_auth->connect('fake_consumer_key');
    }

    /**
     * @expectedException PHPUnit_Framework_Error_Warning
     */
    public function testConnectionRequiresConsumerKey()
    {
        $this->pockpack_auth->connect();
    }

    public function testSuccessfulConnectionReturnsToken()
    {
        $response = new Response(200);
        $response->setBody(json_encode(array(
            'code' => 'fake_token'
        )));

        $this->setPocketResponse($response);

        $token = $this->pockpack_auth->connect('fake_consumer_key');

        $this->assertEquals( 'fake_token', $token );
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

        $this->pockpack_auth->getClient()->addSubscriber($mock);
    }
}
