<?php

use Granada\Orm;

/**
 * Testing extended models
 *
 */
class ExtendedModelTest extends PHPUnit_Framework_TestCase {

    public function setUp() {
        \Cake\Chronos\Chronos::setTestNow(\Cake\Chronos\Chronos::parse('2020-08-10 22:33:52', 'UTC'));

        spl_autoload_register(function ($classname) {
            $nsmodel = explode('\\', $classname);
            $filename = dirname(__DIR__) . "/Auto/" . $nsmodel[0] . '/Models/' . $nsmodel[1] . ".php";
            if (file_exists($filename)) {
                include($filename);
            }

            $filename =  dirname(__DIR__) . "/Auto/" . $nsmodel[0] . '/Models/_base/' . $nsmodel[1] . ".php";
            if (file_exists($filename)) {
                include($filename);
            }

            $filename = dirname(__DIR__) . "/Auto/" . $nsmodel[0] . '/Controllers/' . $nsmodel[1] . ".php";
            if (file_exists($filename)) {
                include($filename);
            }
        });

        // The tests for eager loading requires a real database.
        // Set up SQLite in memory
        ORM::set_db(new PDO('sqlite::memory:'));

        // Create schemas and populate with data
        ORM::get_db()->exec(file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'models.sql'));

        // Enable logging
        ORM::configure('logging', true);
        \MyAppTest\Car::create()->setDatabaseTimezone('Etc/UTC');
    }

    public function tearDown() {
        ORM::configure('logging', false);
        ORM::set_db(null);
    }

    public function testGetter() {
        $car = \MyAppTest\Car::model()->find_one(1);
        $expected = 'Car1';
        $this->assertSame($expected, $car->name);

        $this->assertNull($car->nonExistentProperty);

        $expected = 'test test';
        $car->existingProperty = 'test test';
        $this->assertSame($expected, $car->existingProperty);
    }

    public function testNewItemNoID() {
        $car = \MyAppTest\Car::create(array(
            'name' => 'New Car',
        ))->save();
        $this->assertSame(7, $car->id);
    }

    public function testNewItemBlankID() {
        $car = \MyAppTest\Car::create(array(
            'name' => 'New Car',
        ));
        $car->save();
        $this->assertSame(7, $car->id);
    }

    public function testSetterForRelationship() {
        $car = \MyAppTest\Car::model()
            ->with('manufactor')
            ->find_one(1);
        $expected = 'Manufactor1';
        $this->assertSame($expected, $car->manufactor->name, 'Relationship loaded');

        $expected = 'test';
        $car->manufactor = 'test';

        $this->assertSame($expected, $car->relationships['manufactor'], 'Relationship overloaded');
    }

    public function testfindPairs() {
        $pairs = \MyAppTest\Car::model()
            ->find_pairs('id', 'name');
        $expected = array(
            '1' => 'Car1',
            '2' => 'Car2',
            '3' => 'Car3',
            '4' => 'Car4',
            '6' => 'Car6',
        );
        $this->assertSame($expected, $pairs);
    }

    public function testfindPairsOrdered() {
        $pairs = \MyAppTest\Car::model()
            ->order_by_id_desc()
            ->find_pairs();
        $expected = array(
            '6' => 'Car6',
            '4' => 'Car4',
            '3' => 'Car3',
            '2' => 'Car2',
            '1' => 'Car1',
        );
        $this->assertSame($expected, $pairs);
    }

    public function testfindpairsforceselect() {
        $pairs = \MyAppTest\Car::model()
            ->find_pairs('id', 'manufactor_id');
        $expected = array(
            '1' => '1',
            '2' => '1',
            '3' => '2',
            '4' => '2',
            '6' => '2',
        );
        $this->assertSame($expected, $pairs);
    }

    public function testfindPairsWithJoin() {
        $pairs = \MyAppTest\Car::model()
            ->join('manufactor', 'manufactor.id=car.manufactor_id')
            ->select('car.name', 'car_name')
            ->select('manufactor.name', 'manufactor_name')
            ->find_pairs('car_name', 'manufactor_name');
        $expected = array(
            'Car1' => 'Manufactor1',
            'Car2' => 'Manufactor1',
            'Car3' => 'Manufactor2',
            'Car4' => 'Manufactor2',
            'Car6' => 'Manufactor2',
        );
        $this->assertSame($expected, $pairs);
    }

    public function testfindPairsWithJoinIDName() {
        $pairs = \MyAppTest\Car::model()
            ->join('manufactor', 'manufactor.id=car.manufactor_id')
            ->select('car.name', 'id')
            ->select('manufactor.name', 'name')
            ->find_pairs();
        $expected = array(
            'Car1' => 'Manufactor1',
            'Car2' => 'Manufactor1',
            'Car3' => 'Manufactor2',
            'Car4' => 'Manufactor2',
            'Car6' => 'Manufactor2',
        );
        $this->assertSame($expected, $pairs);
    }

    public function testfindPairsWithJoinOrdered() {
        $pairs = \MyAppTest\Car::model()
            ->join('manufactor', 'manufactor.id=car.manufactor_id')
            ->select('car.name', 'car_name')
            ->select('manufactor.name', 'manufactor_name')
            ->order_by_desc('car.name')
            ->find_pairs('car_name', 'manufactor_name');
        $expected = array(
            'Car6' => 'Manufactor2',
            'Car4' => 'Manufactor2',
            'Car3' => 'Manufactor2',
            'Car2' => 'Manufactor1',
            'Car1' => 'Manufactor1',
        );
        $this->assertSame($expected, $pairs);
    }

    public function testfindPairsWithJoinExpr() {
        $pairs = \MyAppTest\Car::model()
            ->join('manufactor', 'manufactor.id=car.manufactor_id')
            ->join('owner', 'owner.id=car.owner_id')
            ->select('car.name', 'car_name')
            ->select_expr('manufactor.name || " " || owner.name', 'manufactor_name') // For MySQL select_expr('CONCAT(manufactor.name, " ", owner.name)', 'manufactor_name')
            ->find_pairs('car_name', 'manufactor_name');
        $expected = array(
            'Car1' => 'Manufactor1 Owner1',
            'Car2' => 'Manufactor1 Owner2',
            'Car3' => 'Manufactor2 Owner3',
            'Car4' => 'Manufactor2 Owner4',
            'Car6' => 'Manufactor2 Owner4',
        );
        $this->assertSame($expected, $pairs);
    }

    public function testNoResultsfindPairs() {
        $pairs = \MyAppTest\Car::model()
            ->where_id(10)
            ->find_pairs('id', 'name');
        $this->assertSame(array(), $pairs);
    }

    public function testfindManySelect() {
        $cars = \MyAppTest\Car::model()
            ->select('name')
            ->find_many();
        // Not an empty array
        $this->assertNotSame(array(), $cars);
        $this->assertSame(true, $cars->has_results());

        $expected = array(
            '0' => 'Car1',
            '1' => 'Car2',
            '2' => 'Car3',
            '3' => 'Car4',
            '4' => 'Car6',
        );
        foreach ($cars as $id => $car) {
            $this->assertNull($car->id); // We are only getting the name field
            $this->assertSame($expected[$id], $car->name);
        }
    }

    public function testfindManyFirstAndLast() {
        $cars = \MyAppTest\Car::model()
            ->find_many();

        $expected = array(
            'Car1' => array(
                'first' => true,
                'last' => false,
            ),
            'Car2' => array(
                'first' => false,
                'last' => false,
            ),
            'Car3' => array(
                'first' => false,
                'last' => false,
            ),
            'Car4' => array(
                'first' => false,
                'last' => false,
            ),
            'Car6' => array(
                'first' => false,
                'last' => true,
            ),
        );
        foreach ($cars as $car) {
            $this->assertSame($expected[$car->name]['first'], $car->isFirstResult());
            $this->assertSame($expected[$car->name]['last'], $car->isLastResult());
        }
    }

    public function testfindManyFirstAndLastDiffOrder() {
        $cars = \MyAppTest\Car::model()
            ->order_by_id_desc()
            ->find_many();

        $expected = array(
            'Car1' => array(
                'first' => false,
                'last' => true,
            ),
            'Car2' => array(
                'first' => false,
                'last' => false,
            ),
            'Car3' => array(
                'first' => false,
                'last' => false,
            ),
            'Car4' => array(
                'first' => false,
                'last' => false,
            ),
            'Car6' => array(
                'first' => true,
                'last' => false,
            ),
        );
        foreach ($cars as $car) {
            $this->assertSame($expected[$car->name]['first'], $car->isFirstResult());
            $this->assertSame($expected[$car->name]['last'], $car->isLastResult());
        }
    }

    public function testRelatedModelFirstAndLast() {
        $cars = \MyAppTest\Car::model()
            ->find_many();
        // SELECT * FROM `car`

        $expected = array(
            'Car1' => array(
                0 => array(
                    'first' => true,
                    'last' => false,
                ),
                1 => array(
                    'first' => false,
                    'last' => false,
                ),
                2 => array(
                    'first' => false,
                    'last' => true,
                ),
            ),
            'Car2' => array(
                0 => array(
                    'first' => true,
                    'last' => false,
                ),
                1 => array(
                    'first' => false,
                    'last' => true,
                ),
            ),
            'Car3' => array(
                0 => array(
                    'first' => true,
                    'last' => false,
                ),
                1 => array(
                    'first' => false,
                    'last' => true,
                ),
            ),
            'Car4' => array(
                0 => array(
                    'first' => true,
                    'last' => false,
                ),
                1 => array(
                    'first' => false,
                    'last' => true,
                ),
            ),
        );
        foreach ($cars as $car) {
            $partcounter = 0;
            foreach ($car->carParts as $part) {
                $this->assertSame($expected[$car->name][$partcounter]['first'], $part->isFirstResult());
                $this->assertSame($expected[$car->name][$partcounter]['last'], $part->isLastResult());
                $partcounter++;
            }
        }
    }

    public function testRelatedModelFirstAndLastEager() {
        $cars = \MyAppTest\Car::model()
            ->with('carParts')
            ->find_many();
        // SELECT `part`.*, `car_part`.`car_id` FROM `part` JOIN `car_part` ON `part`.`id` = `car_part`.`part_id` WHERE `car_part`.`car_id` IN ('1', '2', '3', '4')

        $expected = array(
            'Car1' => array(
                0 => array(
                    'first' => true,
                    'last' => false,
                ),
                1 => array(
                    'first' => false,
                    'last' => false,
                ),
                2 => array(
                    'first' => false,
                    'last' => true,
                ),
            ),
            'Car2' => array(
                0 => array(
                    'first' => true,
                    'last' => false,
                ),
                1 => array(
                    'first' => false,
                    'last' => true,
                ),
            ),
            'Car3' => array(
                0 => array(
                    'first' => true,
                    'last' => false,
                ),
                1 => array(
                    'first' => false,
                    'last' => true,
                ),
            ),
            'Car4' => array(
                0 => array(
                    'first' => true,
                    'last' => false,
                ),
                1 => array(
                    'first' => false,
                    'last' => true,
                ),
            ),
        );
        foreach ($cars as $car) {
            $partcounter = 0;
            foreach ($car->carParts as $part) {
                $this->assertSame($expected[$car->name][$partcounter]['first'], $part->isFirstResult());
                $this->assertSame($expected[$car->name][$partcounter]['last'], $part->isLastResult());
                $partcounter++;
            }
        }
    }

    public function testfindMany() {
        $cars = \MyAppTest\Car::model()
            ->find_many();
        // Not an empty array
        $this->assertNotSame(array(), $cars);
        $this->assertSame(true, $cars->has_results());

        $expected = array(
            '1' => 'Car1',
            '2' => 'Car2',
            '3' => 'Car3',
            '4' => 'Car4',
            '6' => 'Car6',
        );
        foreach ($cars as $id => $car) {
            $this->assertSame($id, $car->id);
            $this->assertSame($expected[$id], $car->name);
        }
    }

    public function testfindManyFiltered() {
        $cars = \MyAppTest\Car::model()
            ->where_id(3)
            ->find_many();
        // Not an empty array
        $this->assertNotSame(array(), $cars);

        $expected = array(
            '3' => 'Car3',
        );
        foreach ($cars as $id => $car) {
            $this->assertSame($id, $car->id);
            $this->assertSame($expected[$id], $car->name);
        }
    }

    public function testNoResultsfindMany() {
        $cars = \MyAppTest\Car::model()
            ->where_id(10)
            ->find_many();
        $this->assertSame(array(), $cars->as_array());
        $this->assertSame(0, count($cars));
        $this->assertSame(false, $cars->has_results());
    }

    public function testfilters() {
        $car = \MyAppTest\Car::model()
            ->byName('Car1')
            ->find_one();
        $this->assertSame($car->name, 'Car1');
    }

    public function testBooleanType() {
        $car = \MyAppTest\Car::model()
            ->find_one(1);

        $this->assertSame(1, $car->id);
        $this->assertSame(true, $car->enabled);
        $this->assertSame(false, $car->stealth);
        $this->assertSame(false, $car->is_deleted);
    }

    public function testFakeDelete() {
        $car = \MyAppTest\Car::model()
            ->find_one(1);

        $this->assertSame(false, $car->is_deleted);
        $car->delete();

        $car = \MyAppTest\Car::model()
            ->clear_where()
            ->find_one(1);
        $this->assertSame(true, $car->is_deleted);
        $this->assertSame(1, $car->id);
    }

    public function testFakeDeleteForced() {
        $car = \MyAppTest\Car::model()
            ->clear_where()
            ->find_one(1);
        $car->delete(true);

        $car = \MyAppTest\Car::model()
            ->find_one(1);
        $this->assertSame(false, $car);
    }

    public function testInsert() {
        \MyAppTest\Car::insert(array(
            array(
                'id' => '20',
                'name' => 'Car20',
                'manufactor_id' =>  1,
                'owner_id' =>  1,
                'is_deleted' => 0,
            )
        ));
        $count = \MyAppTest\Car::model()->count();
        $expectedSql   = array();
        $expectedSql[] = "INSERT INTO `car` (`id`, `name`, `manufactor_id`, `owner_id`, `is_deleted`, `sort_order`, `updated_at`, `created_at`) VALUES ('20', 'Car20', '1', '1', '0', '7', '2020-08-10 22:33:52', '2020-08-10 22:33:52')";
        $expectedSql[] = "SELECT * FROM `car` WHERE `car`.`is_deleted` = '0' AND `id` = '20' LIMIT 1";
        $expectedSql[] = "SELECT COUNT(*) AS `count` FROM `car` WHERE `car`.`is_deleted` = '0' LIMIT 1";

        $fullQueryLog = ORM::get_query_log();

        // Return last two queries
        $actualSql = array_slice($fullQueryLog, count($fullQueryLog) - 3);

        $this->assertSame($expectedSql, $actualSql);
        $this->assertSame(6, $count, 'Car must be Inserted');
    }

    public function testInsertDeleted() {
        \MyAppTest\Car::insert(array(
            array(
                'id' => '20',
                'name' => 'Car20',
                'manufactor_id' =>  1,
                'owner_id' =>  1,
                'is_deleted' => 1,
            )
        ));
        $count = \MyAppTest\Car::model()->count();
        $expectedSql   = array();
        $expectedSql[] = "INSERT INTO `car` (`id`, `name`, `manufactor_id`, `owner_id`, `is_deleted`, `sort_order`, `updated_at`, `created_at`) VALUES ('20', 'Car20', '1', '1', '1', '7', '2020-08-10 22:33:52', '2020-08-10 22:33:52')";
        $expectedSql[] = "SELECT * FROM `car` WHERE `car`.`is_deleted` = '0' AND `id` = '20' LIMIT 1";
        $expectedSql[] = "SELECT COUNT(*) AS `count` FROM `car` WHERE `car`.`is_deleted` = '0' LIMIT 1";

        $fullQueryLog = ORM::get_query_log();

        // Return last two queries
        $actualSql = array_slice($fullQueryLog, count($fullQueryLog) - 3);

        $this->assertSame($expectedSql, $actualSql);
        $this->assertSame(5, $count);
    }

    public function testCountAll() {
        $count = \MyAppTest\Car::model()->count();
        $expectedSql   = array();
        $expectedSql[] = "SELECT COUNT(*) AS `count` FROM `car` WHERE `car`.`is_deleted` = '0' LIMIT 1";

        $fullQueryLog = ORM::get_query_log();

        // Return last two queries
        $actualSql = array_slice($fullQueryLog, count($fullQueryLog) - 1);

        $this->assertSame($expectedSql, $actualSql);
        $this->assertSame(5, $count);
    }

    public function testCountAllCleared() {
        $count = \MyAppTest\Car::model()->clear_where()->count();
        $expectedSql   = array();
        $expectedSql[] = "SELECT COUNT(*) AS `count` FROM `car` LIMIT 1";

        $fullQueryLog = ORM::get_query_log();

        // Return last two queries
        $actualSql = array_slice($fullQueryLog, count($fullQueryLog) - 1);

        $this->assertSame($expectedSql, $actualSql);
        $this->assertSame(6, $count);
    }

    public function testDirty() {
        $car = \MyAppTest\Car::model()->find_one(1);

        $this->assertSame(false, $car->is_dirty('name'));
        $this->assertSame(1, $car->manufactor_id);

        $car->manufactor_id = 2;
        $this->assertSame(true, $car->is_dirty('manufactor_id'));
        $this->assertSame(2, $car->manufactor_id);
    }

    public function testCleanValue() {
        $car = \MyAppTest\Car::model()->find_one(1);

        $this->assertSame(1, $car->manufactor_id);
        $this->assertSame('1', $car->clean_value('manufactor_id'));
        $car->manufactor_id = 2;
        $this->assertSame('1', $car->clean_value('manufactor_id'));
        $this->assertSame(2, $car->manufactor_id);
        $expected = array(
            'id' => '1',
            'name' => 'Car1',
            'manufactor_id' => '1',
            'owner_id' => '1',
            'enabled' => '1',
            'stealth' => '0',
            'is_deleted' => '0',
            'sort_order' => '6',
            'created_at' => null,
            'updated_at' => null,
        );
        $this->assertSame($expected, $car->clean_values());
        $car->save();
        // Changes after save
        $expected['manufactor_id'] = '2';
        $expected['updated_at'] = '2020-08-10 22:33:52';
        $this->assertSame($expected, $car->clean_values());
    }

    public function testDefaultFilter() {
        $cars = \MyAppTest\Car::model()
            ->defaultFilter()
            ->find_pairs();
        $this->assertSame(array(
            1 => 'Car1',
            2 => 'Car2',
            4 => 'Car4',
        ), $cars);
    }

    public function testFindPairsRepresentative() {
        // Representation of cars is id (as name is null) so we will get a list of names
        $cars = \MyAppTest\Car::model()
            ->find_pairs_representation();
        $this->assertSame(array(
            1 => 'Car1',
            2 => 'Car2',
            3 => 'Car3',
            4 => 'Car4',
            6 => 'Car6',
        ), $cars);
    }

    public function testCreatedAt() {
        $car = \MyAppTest\Car::create(array(
            'name' => 'Test',
        ))->save();

        $expectedSql   = array();
        // Stores datetime in UTC timezone
        $expectedSql[] = "INSERT INTO `car` (`name`, `sort_order`, `updated_at`, `created_at`) VALUES ('Test', '7', '2020-08-10 22:33:52', '2020-08-10 22:33:52')";
        $expectedSql[] = "SELECT * FROM `car` WHERE `car`.`is_deleted` = '0' AND `id` = '7' LIMIT 1";

        $fullQueryLog = ORM::get_query_log();

        // Return last two queries
        $actualSql = array_slice($fullQueryLog, count($fullQueryLog) - 2);

        $this->assertSame($expectedSql, $actualSql);

        // Time in Chicago
        $this->assertSame('2020-08-10 17:33:52', $car->created_at);
        $this->assertSame('2020-08-10 17:33:52', $car->created_at_chronos->toDateTimeString());
        $this->assertSame('America/Chicago', $car->created_at_chronos->timezoneName);
    }

    public function testUpdatedAt() {
        $car = \MyAppTest\Car::create(array(
            'name' => 'Test',
        ))->save();

        // Change time
        \Cake\Chronos\Chronos::setTestNow(\Cake\Chronos\Chronos::parse('2020-08-11 10:08:22', 'UTC'));
        $car->name = 'Test2';
        $car->save();

        $expectedSql   = array();
        // Stores datetime in UTC timezone
        $expectedSql[] = "UPDATE `car` SET `name` = 'Test2', `updated_at` = '2020-08-11 10:08:22' WHERE `id` = '7'";
        $expectedSql[] = "SELECT * FROM `car` WHERE `car`.`is_deleted` = '0' AND `id` = '7' LIMIT 1";

        $fullQueryLog = ORM::get_query_log();

        // Return last two queries
        $actualSql = array_slice($fullQueryLog, count($fullQueryLog) - 2);

        $this->assertSame($expectedSql, $actualSql);

        // Time in Chicago
        $this->assertSame('2020-08-11 05:08:22', $car->updated_at);
        $this->assertSame('2020-08-11 05:08:22', $car->updated_at_chronos->toDateTimeString());
        $this->assertSame('America/Chicago', $car->updated_at_chronos->timezoneName);
    }

    public function testSortOrder() {
        $car = \MyAppTest\Car::create(array(
            'name' => 'New Car',
        ))->save();
        $this->assertSame(7, $car->sort_order);
    }

    public function testTimezoneInWhere() {
        $cars = \MyAppTest\Car::model()->where_created_at_gt(\Cake\Chronos\Chronos::now()->addHour())
            ->find_many();

        $expectedSql = "SELECT * FROM `car` WHERE `car`.`is_deleted` = '0' AND `created_at` > '2020-08-10 23:33:52'";
        $this->assertSame($expectedSql, Orm::get_last_query());
    }

    public function testTimezoneInWhereChangeTimezone() {
        $cars = \MyAppTest\Car::model()->where_created_at_gt(\Cake\Chronos\Chronos::parse('2020-08-10 11:28:23', 'America/Chicago')->addHour())
            ->find_many();

        $expectedSql = "SELECT * FROM `car` WHERE `car`.`is_deleted` = '0' AND `created_at` > '2020-08-10 17:28:23'";
        $this->assertSame($expectedSql, Orm::get_last_query());
    }

    public function testBeforeSave() {
        $carPart = \MyAppTest\CarPart::model()->find_one(1);
        $this->assertSame(1, $carPart->car_id);

        $carPart->save();

        $this->assertSame(1, $carPart->part_id);
        $this->assertSame(4, $carPart->car_id);
    }

    public function testBeforeSaveNew() {
        $carPart = \MyAppTest\CarPart::create(array(
            'car_id' => 2,
        ))->save();

        $this->assertSame(3, $carPart->part_id);
        $this->assertSame(4, $carPart->car_id);
    }

    public function testAfterSave() {
        $carPart = \MyAppTest\CarPart::model()->find_one(1);
        $this->assertSame('Car1', $carPart->car->name);
        $carPart->save();
        $this->assertSame('Is Car Saved', $carPart->car->name);
    }

    public function testAfterSaveNew() {
        $carPart = \MyAppTest\CarPart::create(array(
            'car_id' => 2,
        ))->save();

        $this->assertSame('Is Car Created', $carPart->car->name);
    }

    public function testBeforeDelete() {
        $carPart = \MyAppTest\CarPart::model()->find_one(1);
        $car = $carPart->car;
        $this->assertSame('Car1', $car->name);
        $carPart->delete();
        $car->reload();
        $this->assertSame('Before Delete', $car->name);
        $carPart = \MyAppTest\CarPart::model()->find_one(1);
        $this->assertSame(false, $carPart);
    }

    public function testAfterDelete() {
        $carPart = \MyAppTest\CarPart::model()->find_one(1);
        $part = $carPart->part;
        $this->assertSame('Part1', $part->name);
        $carPart->delete();
        $part->reload();
        $this->assertSame('After Delete', $part->name);
    }

    public function testTimezonesStoredUTC() {

        $timezoneTest = \MyAppTest\TimezoneTest::model()->find_one(1);

        $this->assertSame('2020-08-11 16:47:18', $timezoneTest->datetime1);
        $this->assertSame('2020-08-11 16:47:18', $timezoneTest->datetime1_chronos->toDateTimeString());
        $this->assertSame('America/Chicago', $timezoneTest->datetime1_chronos->getTimezone()->getName());
        $this->assertSame('2020-08-11 21:47:18', $timezoneTest->datetime2);
        $this->assertSame('2020-08-11 21:47:18', $timezoneTest->datetime2_chronos->toDateTimeString());
        $this->assertSame('Etc/UTC', $timezoneTest->datetime2_chronos->getTimezone()->getName());
        $this->assertSame('2020-08-12 05:47:18', $timezoneTest->datetime3);
        $this->assertSame('2020-08-12 05:47:18', $timezoneTest->datetime3_chronos->toDateTimeString());
        $this->assertSame('Australia/Perth', $timezoneTest->datetime3_chronos->getTimezone()->getName());
        $this->assertSame('2020-08-11 16:47:18', $timezoneTest->datetime4);
        $this->assertSame('2020-08-11 16:47:18', $timezoneTest->datetime4_chronos->toDateTimeString());
        $this->assertSame('America/Chicago', $timezoneTest->datetime4_chronos->getTimezone()->getName());
        $this->assertSame('2020-08-11 16:47:18', $timezoneTest->datetime5);
        $this->assertSame('2020-08-11 16:47:18', $timezoneTest->datetime5_chronos->toDateTimeString());
        $this->assertSame('America/Chicago', $timezoneTest->datetime5_chronos->getTimezone()->getName());

        $this->assertSame('2020-08-11', $timezoneTest->date1);
        $this->assertSame('2020-08-11 00:00:00', $timezoneTest->date1_chronos->toDateTimeString());
        $this->assertSame('Australia/Brisbane', $timezoneTest->date1_chronos->getTimezone()->getName());

        $this->assertSame('21:47:18', $timezoneTest->time1);
        $this->assertSame('2020-08-10 21:47:18', $timezoneTest->time1_chronos->toDateTimeString());
        $this->assertSame('Etc/UTC', $timezoneTest->time1_chronos->getTimezone()->getName());

        // Test searches
        $item = \MyAppTest\TimezoneTest::model()
            ->where_datetime1_gt(\Cake\Chronos\Chronos::now())
            ->where_datetime2_gt(\Cake\Chronos\Chronos::now())
            ->where_datetime3_gt(\Cake\Chronos\Chronos::now())
            ->where_datetime4_gt(\Cake\Chronos\Chronos::now())
            ->where_datetime5_gt(\Cake\Chronos\Chronos::now())
            ->find_one();
        $this->assertSame("SELECT * FROM `timezone_test` WHERE `datetime1` > '2020-08-10 22:33:52' AND `datetime2` > '2020-08-11 08:33:52' AND `datetime3` > '2020-08-10 22:33:52' AND `datetime4` > '2020-08-10 17:33:52' AND `datetime5` > '2020-08-11 06:33:52' LIMIT 1", \MyAppTest\TimezoneTest::get_last_query());

        // Set Chronos
        $item->datetime1 = \Cake\Chronos\Chronos::now();
        $item->datetime2 = \Cake\Chronos\Chronos::now();
        $item->datetime3 = \Cake\Chronos\Chronos::now();
        $item->datetime4 = \Cake\Chronos\Chronos::now();
        $item->datetime5 = \Cake\Chronos\Chronos::now();
        $item->save();
        $expectedSql   = array();
        // Stores datetime in UTC timezone
        $expectedSql[] = "UPDATE `timezone_test` SET `datetime1` = '2020-08-10 22:33:52', `datetime2` = '2020-08-10 22:33:52', `datetime3` = '2020-08-10 22:33:52', `datetime4` = '2020-08-10 22:33:52', `datetime5` = '2020-08-10 22:33:52' WHERE `id` = '1'";
        $expectedSql[] = "SELECT * FROM `timezone_test` WHERE `id` = '1' LIMIT 1";

        $fullQueryLog = ORM::get_query_log();

        // Return last two queries
        $actualSql = array_slice($fullQueryLog, count($fullQueryLog) - 2);

        $this->assertSame($expectedSql, $actualSql);

        // Set Time string
        $item->datetime1 = '2020-08-15 11:28:52'; // America/Chicago time is 2020-08-15 16:28:52 UTC
        $this->assertSame('2020-08-15 11:28:52', $item->datetime1);
        $item->datetime2 = '2020-08-15 11:28:52'; // no timezone time
        $this->assertSame('2020-08-15 11:28:52', $item->datetime2);
        $item->datetime3 = '2020-08-15 11:28:52'; // Australia/Perth is 2020-08-15 3:28:52 UTC
        $this->assertSame('2020-08-15 11:28:52', $item->datetime3);
        $item->datetime4 = '2020-08-15 11:28:52'; // America/Chicago time is 2020-08-15 16:28:52 UTC
        $this->assertSame('2020-08-15 11:28:52', $item->datetime4);
        $item->datetime5 = '2020-08-15 11:28:52'; // America/Chicago time is 2020-08-15 16:28:52 UTC
        $this->assertSame('2020-08-15 11:28:52', $item->datetime5);

        $item->save();

        $this->assertSame('2020-08-15 11:28:52', $item->datetime1);
        $this->assertSame('2020-08-15 11:28:52', $item->datetime2);
        $this->assertSame('2020-08-15 11:28:52', $item->datetime3);
        $this->assertSame('2020-08-15 11:28:52', $item->datetime4);
        $this->assertSame('2020-08-15 11:28:52', $item->datetime5);

        $expectedSql   = array();
        // Stores datetime in UTC timezone
        $expectedSql[] = "UPDATE `timezone_test` SET `datetime1` = '2020-08-15 16:28:52', `datetime2` = '2020-08-15 11:28:52', `datetime3` = '2020-08-15 03:28:52', `datetime4` = '2020-08-15 16:28:52', `datetime5` = '2020-08-15 16:28:52' WHERE `id` = '1'";
        $expectedSql[] = "SELECT * FROM `timezone_test` WHERE `id` = '1' LIMIT 1";

        $fullQueryLog = ORM::get_query_log();

        // Return last two queries
        $actualSql = array_slice($fullQueryLog, count($fullQueryLog) - 2);

        $this->assertSame($expectedSql, $actualSql);
    }

    public function testTimezonesStoredBrisbane() {
        $timezoneTest = \MyAppTest\TimezoneTest::model()->find_one(1);
        $timezoneTest->setDatabaseTimezone('Australia/Brisbane');

        $this->assertSame('2020-08-11 06:47:18', $timezoneTest->datetime1);
        $this->assertSame('2020-08-11 06:47:18', $timezoneTest->datetime1_chronos->toDateTimeString());
        $this->assertSame('America/Chicago', $timezoneTest->datetime1_chronos->getTimezone()->getName());
        $this->assertSame('2020-08-11 21:47:18', $timezoneTest->datetime2);
        $this->assertSame('2020-08-11 21:47:18', $timezoneTest->datetime2_chronos->toDateTimeString());
        $this->assertSame('Australia/Brisbane', $timezoneTest->datetime2_chronos->getTimezone()->getName());
        $this->assertSame('2020-08-11 19:47:18', $timezoneTest->datetime3);
        $this->assertSame('2020-08-11 19:47:18', $timezoneTest->datetime3_chronos->toDateTimeString());
        $this->assertSame('Australia/Perth', $timezoneTest->datetime3_chronos->getTimezone()->getName());
        $this->assertSame('2020-08-11 06:47:18', $timezoneTest->datetime4);
        $this->assertSame('2020-08-11 06:47:18', $timezoneTest->datetime4_chronos->toDateTimeString());
        $this->assertSame('America/Chicago', $timezoneTest->datetime4_chronos->getTimezone()->getName());
        $this->assertSame('2020-08-11 06:47:18', $timezoneTest->datetime5);
        $this->assertSame('2020-08-11 06:47:18', $timezoneTest->datetime5_chronos->toDateTimeString());
        $this->assertSame('America/Chicago', $timezoneTest->datetime5_chronos->getTimezone()->getName());

        $this->assertSame('2020-08-11', $timezoneTest->date1);
        $this->assertSame('2020-08-11 00:00:00', $timezoneTest->date1_chronos->toDateTimeString());
        $this->assertSame('Australia/Brisbane', $timezoneTest->date1_chronos->getTimezone()->getName());

        $this->assertSame('21:47:18', $timezoneTest->time1);
        $this->assertSame('2020-08-10 21:47:18', $timezoneTest->time1_chronos->toDateTimeString());
        $this->assertSame('Australia/Brisbane', $timezoneTest->time1_chronos->getTimezone()->getName());

        // Test searches
        $item = \MyAppTest\TimezoneTest::model()
            ->where_datetime1_gt(\Cake\Chronos\Chronos::now())
            ->where_datetime2_gt(\Cake\Chronos\Chronos::now())
            ->where_datetime3_gt(\Cake\Chronos\Chronos::now())
            ->where_datetime4_gt(\Cake\Chronos\Chronos::now())
            ->where_datetime5_gt(\Cake\Chronos\Chronos::now())
            ->find_one();

        $this->assertSame("SELECT * FROM `timezone_test` WHERE `datetime1` > '2020-08-11 08:33:52' AND `datetime2` > '2020-08-11 08:33:52' AND `datetime3` > '2020-08-11 08:33:52' AND `datetime4` > '2020-08-10 17:33:52' AND `datetime5` > '2020-08-11 06:33:52' LIMIT 1", \MyAppTest\TimezoneTest::get_last_query());

        // Set
        $item->datetime1 = \Cake\Chronos\Chronos::now();
        $item->datetime2 = \Cake\Chronos\Chronos::now();
        $item->datetime3 = \Cake\Chronos\Chronos::now();
        $item->datetime4 = \Cake\Chronos\Chronos::now();
        $item->datetime5 = \Cake\Chronos\Chronos::now();
        $item->save();
        $expectedSql   = array();
        // Stores datetime in Australia/Brisbane timezone
        $expectedSql[] = "UPDATE `timezone_test` SET `datetime1` = '2020-08-11 08:33:52', `datetime2` = '2020-08-11 08:33:52', `datetime3` = '2020-08-11 08:33:52', `datetime4` = '2020-08-11 08:33:52', `datetime5` = '2020-08-11 08:33:52' WHERE `id` = '1'";
        $expectedSql[] = "SELECT * FROM `timezone_test` WHERE `id` = '1' LIMIT 1";

        $fullQueryLog = ORM::get_query_log();

        // Return last two queries
        $actualSql = array_slice($fullQueryLog, count($fullQueryLog) - 2);

        $this->assertSame($expectedSql, $actualSql);

        // Set Time string
        $item->datetime1 = '2020-08-15 11:28:52'; // America/Chicago time is 2020-08-16 02:28:52 Australia/Brisbane
        $this->assertSame('2020-08-15 11:28:52', $item->datetime1);
        $item->datetime2 = '2020-08-15 11:28:52'; // no timezone time
        $this->assertSame('2020-08-15 11:28:52', $item->datetime2);
        $item->datetime3 = '2020-08-15 11:28:52'; // Australia/Perth is 2020-08-15 13:28:52 Australia/Brisbane
        $this->assertSame('2020-08-15 11:28:52', $item->datetime3);
        $item->datetime4 = '2020-08-15 11:28:52'; // America/Chicago time is 2020-08-16 02:28:52 Australia/Brisbane
        $this->assertSame('2020-08-15 11:28:52', $item->datetime4);
        $item->datetime5 = '2020-08-15 11:28:52'; // America/Chicago time is 2020-08-16 02:28:52 Australia/Brisbane
        $this->assertSame('2020-08-15 11:28:52', $item->datetime5);

        $item->save();

        $this->assertSame('2020-08-15 11:28:52', $item->datetime1);
        $this->assertSame('2020-08-15 11:28:52', $item->datetime2);
        $this->assertSame('2020-08-15 11:28:52', $item->datetime3);
        $this->assertSame('2020-08-15 11:28:52', $item->datetime4);
        $this->assertSame('2020-08-15 11:28:52', $item->datetime5);

        $expectedSql   = array();
        // Stores datetime in UTC timezone
        $expectedSql[] = "UPDATE `timezone_test` SET `datetime1` = '2020-08-16 02:28:52', `datetime2` = '2020-08-15 11:28:52', `datetime3` = '2020-08-15 13:28:52', `datetime4` = '2020-08-16 02:28:52', `datetime5` = '2020-08-16 02:28:52' WHERE `id` = '1'";
        $expectedSql[] = "SELECT * FROM `timezone_test` WHERE `id` = '1' LIMIT 1";

        $fullQueryLog = ORM::get_query_log();

        // Return last two queries
        $actualSql = array_slice($fullQueryLog, count($fullQueryLog) - 2);

        $this->assertSame($expectedSql, $actualSql);
    }
}
