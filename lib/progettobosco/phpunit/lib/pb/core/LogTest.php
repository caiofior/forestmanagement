<?php

/**
 * Generated by PHPUnit_SkeletonGenerator 1.2.0 on 2013-01-15 at 11:36:41.
 */
$PHPUNIT = true;
require (__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'include' . DIRECTORY_SEPARATOR . 'pageboot.php');
require ('PHPUnit/Autoload.php');
class LogTest extends PHPUnit_Framework_TestCase {

    /**
     * @var Log
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp() {
        $this->object = new Log;
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown() {
         $db = Zend_Db_Table::getDefaultAdapter();
         $db->query('DELETE FROM "log" ;');
    }

    /**
     * @covers Log::loadFromId
     */
    public function testLoadFromId() {
        $this->object->setData('Test', 'text');
        $this->object->insert();
        $id = $this->object->getData('id');
        $this->object->loadFromId($id);
        $this->setExpectedException('Exception');
        $this->object->loadFromId(9999);
    }

    /**
     * @covers Log::getData
     */
    public function testGetData() {
        $this->object->setData('Test', 'text');
        $this->object->insert();
        $id = $this->object->getData('id');

    }

    /**
     * @covers Log::setData
     */
    public function testSetData() {
        $this->object->setData('Test', 'text');
        $this->object->insert();

    }

    /**
     * @covers Log::insert
     */
    public function testInsert() {
        $this->object->setData('Test', 'text');
        $this->object->insert();

    }

    /**
     * @covers Log::delete
     */
    public function testDelete() {
        $this->object->setData('Test', 'text');
        $this->object->insert();
        $id = $this->object->getData('id');
        $this->object->loadFromId($id);
        $this->object->delete();

    }

}
