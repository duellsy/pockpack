<?php

class PocketExceptionTest extends PHPUnit_Framework_TestCase
{


    public function setUp()
    {

    }

    public function tearDown()
    {
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
    public function testNoItemExceptionWhenAdding()
    {
        $pockpack_q = new Duellsy\Pockpack\PockpackQueue();
        $pockpack_q->add(array('item_id' => 123));
    }



    /**
     * @expectedException Duellsy\Pockpack\NoItemException
     */
    public function testNoItemExceptionWhenModifying()
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
