<?php

class PocketQueueTest extends PHPUnit_Framework_TestCase
{


    public function setUp()
    {
    }

    public function tearDown()
    {
    }


    public function testAddBookmarkAddsToQueue()
    {

        $pockpack_q = new Duellsy\Pockpack\PockpackQueue();
        $pockpack_q->add(array(
            'url'   => 'http://www.example.com'
        ));

        $this->assertEquals(1, sizeof($pockpack_q->getActions()));

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




}
