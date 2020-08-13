<?php

/**
 * This is the base model class for the database table 'timezone_test'
 *
 * Do not modify this file, it is overwritten via the db2model script
 * If any changes are required, override them in the 'MyAppTest\TimezoneTest' class.
 */

namespace MyAppTest;

/**
 * @property integer $id
 * @property string $datetime1
 * @property \Cake\Chronos\Chronos $datetime1_chronos
 * @property string $datetime2
 * @property \Cake\Chronos\Chronos $datetime2_chronos
 * @property string $datetime3
 * @property \Cake\Chronos\Chronos $datetime3_chronos
 * @property string $datetime4
 * @property \Cake\Chronos\Chronos $datetime4_chronos
 * @property string $datetime5
 * @property \Cake\Chronos\Chronos $datetime5_chronos
 * @property string $date1
 * @property \Cake\Chronos\Chronos $date1_chronos
 * @property string $time1
 * @property \Cake\Chronos\Chronos $time1_chronos
 *
 * @method \MyAppTest\TimezoneTest save(boolean $ignore = false) Save and reload the model, optionally ignoring existing id (Use INSERT ON DUPLICATE KEY UPDATE query).
 */
abstract class BaseTimezoneTest extends \MyAppTest\ORMBaseClass {
    public static $_table = 'timezone_test';

	/**
	 * Starting point for all queries
	 * @return \MyAppTest\QueryTimezoneTest
	 */
	public static function model() {
		return \Granada\Granada::factory('MyAppTest\TimezoneTest');
	}

	/**
	 * @return string The current namespace
	 */
	public function getNamespace() {
		return 'MyAppTest';
	}

	/**
	 * @return string The current model name
	 */
	public function getModelname() {
		return 'TimezoneTest';
	}

	/**
	 * Get the type of variable for the field
	 * @var string $field_name
	 * @return string
	 */
	public function fieldType($field_name) {
		$fields = array(
			'id' => 'integer',
			'datetime1' => 'datetime',
			'datetime2' => 'datetime',
			'datetime3' => 'datetime',
			'datetime4' => 'datetime',
			'datetime5' => 'datetime',
			'date1' => 'date',
			'time1' => 'time',
		);
		if (!array_key_exists($field_name, $fields)) {
			return false;
		}
		return $fields[$field_name];
	}

	/**
	 * Get the database table name
	 *
	 * @return string Table name
	 */
	public function tableName() {
		return 'timezone_test';
	}

	/**
	 * Get the human-readable name for the model
	 *
	 * @return string
	 */
	public static function humanName() {
		return 'Timezone Test';
	}

	/**
	 * Get the plural version of human-readable name for the model
	 *
	 * @return string
	 */
	public static function humanNames() {
		return \Granada\Autobuild::pluralize('Timezone Test');
	}

	/**
	 * The columns used as part of the representation method
	 */
	public static function uniqueColumns() {
		return array(
		);
	}

	/**
	 * The column used as the main identifier for the model
	 */
	public static function defaultOrder() {
		return 'id';
	}

	/**
	 * The column used as the main identifier for the model
	 */
	public static function primaryColumn() {
		return 'id';
	}

	/**
	 * The value of the main identifier for the model
	 */
	public function representation() {
		return $this->id;
	}

    /**
     * The columns used as part of the representation method
     */
    public static function representationColumns() {
            return array('id');
    }

	/**
	 * Any fields listed in this array will not affect the updated_at and created_at timestamp fields on save
	 * Override to ignore more
	 */
	public function ignoreDirtyForTimestamps() {
		return array(
			'sort_order',
		);
	}

	/**
	 * Check that the model has a field name
	 *
	 * @var string $field
	 * @return boolean
	 */
	public static function hasAttribute($field) {
		return array_key_exists($field, array(
			'id' => true,
			'datetime1' => true,
			'datetime2' => true,
			'datetime3' => true,
			'datetime4' => true,
			'datetime5' => true,
			'date1' => true,
			'time1' => true,
		));
	}

	/**
	 * Set attributes for an item in bulk
	 * Array has the property name as the keys
	 *
	 * @param array $data
	 * @return \MyAppTest\TimezoneTest
	 */
	public function setAttributes($data) {
		foreach ($data as $key => $val) {
			if (\MyAppTest\TimezoneTest::hasAttribute($key) && $this->{$key} !== $val) {
				$this->{$key} = $val;
			}
		}
		return $this;
	}

	/**
	 * Get list of date fields, used for timezone conversion
	 *
	 * @return array list of fields
	 */
	public function datefields() {
		return array(
			'datetime1' => array(
				'type' => 'datetime',
				'format' => 'Y-m-d H:i:s',
				'timezone_mode' => 'user',
				'timezone_comparison_mode' => 'none',
			),
			'datetime2' => array(
				'type' => 'datetime',
				'format' => 'Y-m-d H:i:s',
				'timezone_mode' => 'none',
				'timezone_comparison_mode' => 'none',
			),
			'datetime3' => array(
				'type' => 'datetime',
				'format' => 'Y-m-d H:i:s',
				'timezone_mode' => 'site',
				'timezone_comparison_mode' => 'none',
			),
			'datetime4' => array(
				'type' => 'datetime',
				'format' => 'Y-m-d H:i:s',
				'timezone_mode' => 'user',
				'timezone_comparison_mode' => 'user',
			),
			'datetime5' => array(
				'type' => 'datetime',
				'format' => 'Y-m-d H:i:s',
				'timezone_mode' => 'user',
				'timezone_comparison_mode' => 'site',
			),
			'date1' => array(
				'type' => 'date',
				'format' => 'Y-m-d',
				'timezone_mode' => 'user',
				'timezone_comparison_mode' => 'none',
			),
			'time1' => array(
				'type' => 'time',
				'format' => 'H:i:s',
				'timezone_mode' => 'none',
				'timezone_comparison_mode' => 'none',
			),
		);
	}


	/**
	 * Should we delete this record for real or just flag as deleted?
	 * Uses the is_deleted field
	 *
	 * @return boolean
	 */
	public function fakeDelete() {
		return false;
	}

	public static function field_tags($field) {
		$tags = array(
			'id' => array(

			),
			'datetime1' => array(

			),
			'datetime2' => array(

			),
			'datetime3' => array(

			),
			'datetime4' => array(

			),
			'datetime5' => array(

			),
			'date1' => array(

			),
			'time1' => array(

			),
		);
		if (!array_key_exists($field, $tags)) {
			return array();
		}
		return $tags[$field];
	}
}