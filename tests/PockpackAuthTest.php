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
            'code' => 'fake_request_token'
        )));

        $this->setPocketResponse($response);

        $token = $this->pockpack_auth->connect('fake_consumer_key');

        $this->assertEquals( 'fake_request_token', $token );
    }

    public function testReceivingAccessToken()
    {
        $response = new Response(200);
        $response->setBody(json_encode(array(
            'access_token' => 'fake_access_token'
        )));

        $this->setPocketResponse($response);

        $token = $this->pockpack_auth->receiveToken('fake_consumer_key', 'fake_access_token');

        $this->assertEquals( 'fake_access_token', $token );
    }

    public function testReceivingAccessTokenAndUsername()
    {
        $response = new Response(200);
        $response->setBody(json_encode(array(
            'access_token' => 'fake_access_token',
            'username' => 'acairns'
        )));

        $this->setPocketResponse($response);

        $data = $this->pockpack_auth->receiveTokenAndUsername('fake_consumer_key', 'fake_access_token');

        $this->assertEquals( 'fake_access_token', $data['access_token'] );
        $this->assertEquals( 'acairns', $data['username'] );
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
