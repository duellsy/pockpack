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

    public function testSending()
    {
        $response = new Response(200);
        $response->setBody(json_encode(array(
            'action_results' => array(true),
            'status' => 1,
        )));
        $this->setPocketResponse($response);

        $pockpack_q = new Duellsy\Pockpack\PockpackQueue();
        $pockpack_q->add(array(
            'url'   => 'http://www.example.com'
        ));

        $response = $this->pockpack->send($pockpack_q);
        $this->assertEquals(1, $response->status);
        $this->assertCount(1, $response->action_results);
        $this->assertTrue($response->action_results[0]);
    }

    public function testRetrieving()
    {
        $response = new Response(200);
        $response->setBody(json_encode(array(
            'status' => 1,
            'complete' => 1,
            'list' => array(
                123 => array(
                    'item_id' => 123,
                    'resolved_id' => 123,
                    'given_url' => 'http://acairns.co.uk',
                    'given_title' => 'Andrew Cairns',
                    'favorite' => 0,
                    'status' => 0,
                    'time_added' => time(),
                    'time_updated' => time(),
                    'time_read' => 0,
                    'time_favorited' => 0,
                    'sort_id' => 0,
                    'resolved_title' => 'Andrew Cairns',
                    'resolved_url' => 'http://acairns.co.uk',
                    'excerpt' => 'Some excerpt about something',
                    'is_article' => 0,
                    'is_index' => 0,
                    'has_video' => 0,
                    'has_image' => 0,
                    'word_count' => 123
                )
            )
        )));

        $this->setPocketResponse($response);

        $response = $this->pockpack->retrieve();

        $this->assertEquals(1, $response->status);
        $this->assertEquals(1, $response->complete);
        
        $this->assertNotEmpty($response->list);
        $this->assertNotEmpty($response->list->{123});

        $item = $response->list->{123};

        $this->assertEquals(123, $item->item_id);
        $this->assertEquals(123, $item->resolved_id);
        $this->assertEquals('Andrew Cairns', $item->given_title);
        $this->assertEquals('Andrew Cairns', $item->resolved_title);
        $this->assertEquals('http://acairns.co.uk', $item->given_url);
        $this->assertEquals('http://acairns.co.uk', $item->resolved_url);
        $this->assertEquals('Some excerpt about something', $item->excerpt);
        $this->assertEquals(0, $item->is_article);
        $this->assertEquals(0, $item->favorite);
        $this->assertEquals(0, $item->status);
        $this->assertEquals(0, $item->time_read);
        $this->assertEquals(0, $item->time_favorited);
        $this->assertEquals(0, $item->sort_id);
        $this->assertEquals(0, $item->is_index);
        $this->assertEquals(0, $item->has_video);
        $this->assertEquals(0, $item->has_image);
        $this->assertEquals(123, $item->word_count);
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
