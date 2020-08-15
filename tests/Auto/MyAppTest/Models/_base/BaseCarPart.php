<?php

/**
 * This is the base model class for the database table 'car_part'
 *
 * Do not modify this file, it is overwritten via the db2model script
 * If any changes are required, override them in the 'MyAppTest\CarPart' class.
 */

namespace MyAppTest;

/**
 * @property integer $id
 * @property integer $car_id
 * @property integer $part_id
 * @property \MyAppTest\Car $car
 * @property \MyAppTest\Part $part
 *
 * @method \MyAppTest\CarPart save(boolean $ignore = false) Save and reload the model, optionally ignoring existing id (Use INSERT ON DUPLICATE KEY UPDATE query).
 */
abstract class BaseCarPart extends \MyAppTest\ORMBaseClass {
    public static $_table = 'car_part';

	/**
	 * Starting point for all queries
	 * @return \MyAppTest\QueryCarPart
	 */
	public static function model() {
		return \Granada\Granada::factory('MyAppTest\CarPart');
	}

    public function car() {
        return $this->belongs_to('MyAppTest\Car', 'car_id');
    }

    public function part() {
        return $this->belongs_to('MyAppTest\Part', 'part_id');
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
		return 'CarPart';
	}

	/**
	 * Get the type of variable for the field
	 * @var string $field_name
	 * @return string
	 */
	public function fieldType($field_name) {
		$fields = array(
			'id' => 'integer',
			'car_id' => 'integer',
			'part_id' => 'integer',
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
		return 'car_part';
	}

	/**
	 * Get the human-readable name for the model
	 *
	 * @return string
	 */
	public static function humanName() {
		return 'Car Part';
	}

	/**
	 * Get the plural version of human-readable name for the model
	 *
	 * @return string
	 */
	public static function humanNames() {
		return \Granada\Autobuild::pluralize('Car Part');
	}

	/**
	 * The columns used as part of the representation method
	 */
	public static function uniqueColumns() {
		return array(
		);
	}

	/**
	 * Is this model a nestedSet ?
	 * @return boolean
	 */
	public static function isNestedSet() {
		return false;
	}

	/**
	 * The column used as the main identifier for the model
	 * @return string
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
			'car_id' => true,
			'part_id' => true,
		));
	}

	/**
	 * Set attributes for an item in bulk
	 * Array has the property name as the keys
	 *
	 * @param array $data
	 * @return \MyAppTest\CarPart
	 */
	public function setAttributes($data) {
		foreach ($data as $key => $val) {
			if (\MyAppTest\CarPart::hasAttribute($key) && $this->{$key} !== $val) {
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

	/**
	 * Get the list of tags from the database comment
	 * @param string $field the field name
	 * @return string[] list of comment tags (_ prefixes)
	 */
	public static function field_tags($field) {
		$tags = array(
			'id' => array(
			),
			'car_id' => array(
			),
			'part_id' => array(
			),
		);
		if (!array_key_exists($field, $tags)) {
			return array();
		}
		return $tags[$field];
	}

	/**
	 * Get the help text from the database comment.
	 * It is basically the comment minus the tags (_ prefixes)
	 * @param string $field the field name
	 * @return string The field comment
	 */
	public static function field_help_text($field) {
		$items = array(
			'id' => '',
			'car_id' => '',
			'part_id' => '',
		);
		if (!array_key_exists($field, $items)) {
			return array();
		}
		return $items[$field];
	}

	/**
	 * Get the fields for edit forms
	 * @return string[] form fields
	 */
	public static function form_fields() {
		return array(
			'car_id',
			'part_id',
		);
	}

	/**
	 * Get the field default value
	 * @param string $field
	 * @return integer
	 */
	public static function field_default_value($field) {
		$items = array(
			'id' => '',
			'car_id' => '',
			'part_id' => '',
		);
		if (!array_key_exists($field, $items)) {
			return 0;
		}
		return $items[$field];
	}

	/**
	 * Get the field max length
	 * @param string $field
	 * @return integer
	 */
	public static function field_length($field) {
		$items = array(
			'id' => 11,
			'car_id' => 11,
			'part_id' => 11,
		);
		if (!array_key_exists($field, $items)) {
			return 0;
		}
		return $items[$field];
	}

	/**
	 * Get whether the field is required
	 * @param string $field
	 * @return integer
	 */
	public static function field_is_required($field) {
		$items = array(
			'id' => false,
			'car_id' => false,
			'part_id' => false,
		);
		if (!array_key_exists($field, $items)) {
			return 0;
		}
		return $items[$field];
	}
}