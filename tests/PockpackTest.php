<?php

use Guzzle\Plugin\Mock\MockPlugin;
use Guzzle\Http\Message\Response;

class PocketTest extends PHPUnit_Framework_TestCase
{
    /**
     * @expectedException Guzzle\Http\Exception\ClientErrorResponseException
     */
    public function testSimpleMocking()
    {
        $pockpack = new Duellsy\Pockpack\Pockpack('fake_consumer_key', 'fake_access_token');

        $client = $pockpack->getClient();

        $mock = new MockPlugin();
        $mock->addResponse(new Response(404));

        $client->addSubscriber($mock);

        $pockpack->setClient($client);

        $pockpack->retrieve();
    }
}
