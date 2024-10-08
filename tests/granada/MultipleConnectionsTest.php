<?php

use Granada\Orm;
use Granada\Model;

class MultipleConnectionsTest extends \PHPUnit\Framework\TestCase
{
    public const ALTERNATE = 'alternate';

    /**
     * @before
     */
    protected function beforeTest()
    {
        // Set up the dummy database connection
        ORM::set_db(new MockPDO('sqlite::memory:'));
        ORM::set_db(new MockDifferentPDO('sqlite::memory:'), self::ALTERNATE);

        // Enable logging
        ORM::configure('logging', true);
        ORM::configure('logging', true, self::ALTERNATE);
    }

    /**
     * @after
     */
    protected function afterTest()
    {
        ORM::configure('logging', false);
        ORM::configure('logging', false, self::ALTERNATE);

        ORM::set_db(null);
        ORM::set_db(null, self::ALTERNATE);
    }

    public function testMultipleConnections()
    {
        $simple    = Model::factory('Simple')->find_one(1);
        $statement = ORM::get_last_statement();
        $this->assertInstanceOf('MockPDOStatement', $statement);

        $simple = Model::factory('Simple', self::ALTERNATE); // Change the object's default connection
        $simple->find_one(1);
        $statement = ORM::get_last_statement();
        $this->assertInstanceOf('MockDifferentPDOStatement', $statement);

        $temp      = Model::factory('Simple', self::ALTERNATE)->find_one(1);
        $statement = ORM::get_last_statement();
        $this->assertInstanceOf('MockDifferentPDOStatement', $statement);
    }

    public function testCustomConnectionName()
    {
        $person3   = Model::factory('ModelWithCustomConnection')->find_one(1);
        $statement = ORM::get_last_statement();
        $this->assertInstanceOf('MockDifferentPDOStatement', $statement);
    }
}
