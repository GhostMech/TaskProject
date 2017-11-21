<?php
/**
 * Created by PhpStorm.
 * User: sp.student
 * Date: 11/21/2017
 * Time: 3:18 PM
 */

use PHPUnit\Framework\TestCase;
use GMH\JsonStorage;

class JsonStorageTest extends TestCase
{
    protected $storage;

    /**
     * Set up a JsonStorage instance.
     *
     */
    public function setUp()
    {
        $this->storage = new JsonStorage('tasks.json');
    }

    public function testTrue()
    {
        $this->assertTrue(true);
    }

    /**
     * Test that the storage property is a JsonStorage instance.
     *
     */
    public function testJsonStorageExists()
    {
        $this->assertInstanceOf('GMH\JsonStorage', $this->storage);
    }
}
