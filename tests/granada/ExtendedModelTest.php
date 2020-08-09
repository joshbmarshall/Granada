<?php

use Granada\Orm;

/**
 * Testing extended models
 *
 */
class ExtendedModelTest extends PHPUnit_Framework_TestCase {

    public function setUp() {

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
            'id' => '',
            'name' => 'New Car',
        ));
        $car->save();
        $this->assertSame(9, $car->id);
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
        $expectedSql[] = "INSERT INTO `car` (`id`, `name`, `manufactor_id`, `owner_id`, `is_deleted`) VALUES ('20', 'test', '1', '1', '0')";
        $expectedSql[] = "SELECT COUNT(*) AS `count` FROM `car` WHERE `car`.`is_deleted` = '0' LIMIT 1";

        $fullQueryLog = ORM::get_query_log();

        // Return last two queries
        $actualSql = array_slice($fullQueryLog, count($fullQueryLog) - 2);

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
        $expectedSql[] = "INSERT INTO `car` (`id`, `name`, `manufactor_id`, `owner_id`, `is_deleted`) VALUES ('20', 'test', '1', '1', '1')";
        $expectedSql[] = "SELECT COUNT(*) AS `count` FROM `car` WHERE `car`.`is_deleted` = '0' LIMIT 1";

        $fullQueryLog = ORM::get_query_log();

        // Return last two queries
        $actualSql = array_slice($fullQueryLog, count($fullQueryLog) - 2);

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
            'created_at' => null,
            'updated_at' => null,
        );
        $this->assertSame($expected, $car->clean_values());
        $car->save();
        // Changes after save
        $expected['manufactor_id'] = 2;
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
    }

    public function testTimezone() {
    }

    public function testBeforeSave() {
    }

    public function testBeforeSaveNew() {
    }

    public function testAfterSave() {
    }

    public function testAfterSaveNew() {
    }

    public function testBeforeDelete() {
    }

    public function testAfterDelete() {
    }

}
