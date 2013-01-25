<?php

use \Mockery as m;

class PocketConnectionTest extends PHPUnit_Framework_TestCase
{


    public function setUp()
    {

    }

    public function tearDown()
    {
        m::close();
    }


    public function testFavoriteBookmarkAddsToQueue()
    {

        $pockpack_q = new Duellsy\Pockpack\PockpackQueue();
        $pockpack_q->favorite(123);

        $this->assertEquals(1, sizeof($pockpack_q->getActions()));

    }


    public function testUnFavoriteBookmarkAddsToQueue()
    {

        $pockpack_q = new Duellsy\Pockpack\PockpackQueue();
        $pockpack_q->unfavorite(123);

        $this->assertEquals(1, sizeof($pockpack_q->getActions()));

    }


    public function testArchiveBookmarkAddsToQueue()
    {

        $pockpack_q = new Duellsy\Pockpack\PockpackQueue();
        $pockpack_q->archive(123);

        $this->assertEquals(1, sizeof($pockpack_q->getActions()));

    }


    public function testReAddBookmarkAddsToQueue()
    {

        $pockpack_q = new Duellsy\Pockpack\PockpackQueue();
        $pockpack_q->readd(123);

        $this->assertEquals(1, sizeof($pockpack_q->getActions()));

    }



    public function testDeleteBookmarkAddsToQueue()
    {

        $pockpack_q = new Duellsy\Pockpack\PockpackQueue();
        $pockpack_q->delete(123);

        $this->assertEquals(1, sizeof($pockpack_q->getActions()));

    }




    public function testAddMultipleItemsToQueue()
    {

        $pockpack_q = new Duellsy\Pockpack\PockpackQueue();
        $pockpack_q->favorite(123);
        $pockpack_q->delete(123);

        $this->assertEquals(2, sizeof($pockpack_q->getActions()));

    }



    public function testCallingPockpackClearClearsLocalQueue()
    {

        $pockpack_q = new Duellsy\Pockpack\PockpackQueue();
        $pockpack_q->favorite(123);
        $pockpack_q->delete(123);

        $pockpack_q->clear();

        $this->assertEquals(0, sizeof($pockpack_q->getActions()));

    }



    /**
     * @expectedException Duellsy\Pockpack\EmptyConstructorException
     */
    public function testPockpackConstructorRequiredParamsException()
    {
        $pockpack = new Duellsy\Pockpack\Pockpack();
    }



    /**
     * @expectedException Duellsy\Pockpack\NoConsumerKeyException
     */
    public function testPockpackAuthConnectException()
    {
        $pockpackauth = new Duellsy\Pockpack\PockpackAuth();
        $pockpackauth->connect();
    }



    /**
     * @expectedException Duellsy\Pockpack\NoItemException
     */
    public function testNoItemException()
    {
        $pockpack_q = new Duellsy\Pockpack\PockpackQueue();
        $pockpack_q->favorite();
    }



    /**
     * @expectedException Duellsy\Pockpack\InvalidItemTypeException
     */
    public function testInvalidItemTypeException()
    {
        $pockpack_q = new Duellsy\Pockpack\PockpackQueue();
        $pockpack_q->favorite("abc");
    }



    /**
     * @expectedException Duellsy\Pockpack\NoPockpackQueueException
     */
    public function testNoPockpackQueueException()
    {
        $pockpack = new Duellsy\Pockpack\Pockpack("fake_key", "fake_token");
        $pockpack->send();
    }




}
