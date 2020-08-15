<?php

/**
 * This is the base model class for the database table 'car'
 *
 * Do not modify this file, it is overwritten via the db2model script
 * If any changes are required, override them in the 'MyAppTest\Car' class.
 */

namespace MyAppTest;

/**
 * @property integer $id
 * @property string $name
 * @property integer $manufactor_id
 * @property integer $owner_id
 * @property boolean $enabled
 * @property boolean $stealth
 * @property boolean $is_deleted
 * @property integer $sort_order
 * @property string $created_at
 * @property \Cake\Chronos\Chronos $created_at_chronos
 * @property string $updated_at
 * @property \Cake\Chronos\Chronos $updated_at_chronos
 * @property \MyAppTest\Manufactor $manufactor
 * @property \MyAppTest\Owner $owner
 * @property \MyAppTest\CarPart[] $carParts
 *
 * @method \MyAppTest\Car save(boolean $ignore = false) Save and reload the model, optionally ignoring existing id (Use INSERT ON DUPLICATE KEY UPDATE query).
 */
abstract class BaseCar extends \MyAppTest\ORMBaseClass {
    public static $_table = 'car';

	/**
	 * Starting point for all queries
	 * @return \MyAppTest\QueryCar
	 */
	public static function model() {
		return \Granada\Granada::factory('MyAppTest\Car');
	}

    public function manufactor() {
        return $this->belongs_to('MyAppTest\Manufactor', 'manufactor_id');
    }

    public function owner() {
        return $this->belongs_to('MyAppTest\Owner', 'owner_id');
    }

    public function carParts() {
        return $this->has_many('MyAppTest\CarPart', 'car_id')->defaultFilter()->order_by_expr(\MyAppTest\CarPart::defaultOrder());
    }

    /**
     * Get the field name of the CarPart that links back to this Car
     * @return string
     */
    public function carParts_refVar() {
            return 'car_id';
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
		return 'Car';
	}

	/**
	 * Get the type of variable for the field
	 * @var string $field_name
	 * @return string
	 */
	public function fieldType($field_name) {
		$fields = array(
			'id' => 'integer',
			'name' => 'string',
			'manufactor_id' => 'integer',
			'owner_id' => 'integer',
			'enabled' => 'boolean',
			'stealth' => 'boolean',
			'is_deleted' => 'boolean',
			'sort_order' => 'integer',
			'created_at' => 'datetime',
			'updated_at' => 'datetime',
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
		return 'car';
	}

	/**
	 * Get the human-readable name for the model
	 *
	 * @return string
	 */
	public static function humanName() {
		return 'Car';
	}

	/**
	 * Get the plural version of human-readable name for the model
	 *
	 * @return string
	 */
	public static function humanNames() {
		return \Granada\Autobuild::pluralize('Car');
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
		return 'sort_order';
	}

	/**
	 * The column used as the main identifier for the model
	 */
	public static function primaryColumn() {
		return 'name';
	}

	/**
	 * The value of the main identifier for the model
	 */
	public function representation() {
		return $this->name;
	}

    /**
     * The columns used as part of the representation method
     */
    public static function representationColumns() {
            return array('name');
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
			'name' => true,
			'manufactor_id' => true,
			'owner_id' => true,
			'enabled' => true,
			'stealth' => true,
			'is_deleted' => true,
			'sort_order' => true,
			'created_at' => true,
			'updated_at' => true,
		));
	}

	/**
	 * Set attributes for an item in bulk
	 * Array has the property name as the keys
	 *
	 * @param array $data
	 * @return \MyAppTest\Car
	 */
	public function setAttributes($data) {
		foreach ($data as $key => $val) {
			if (\MyAppTest\Car::hasAttribute($key) && $this->{$key} !== $val) {
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
			'created_at' => array(
				'type' => 'datetime',
				'format' => 'Y-m-d H:i:s',
				'timezone_mode' => 'user',
				'timezone_comparison_mode' => 'none',
			),
			'updated_at' => array(
				'type' => 'datetime',
				'format' => 'Y-m-d H:i:s',
				'timezone_mode' => 'user',
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
		return true;
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
			'name' => array(
			),
			'manufactor_id' => array(
			),
			'owner_id' => array(
			),
			'enabled' => array(
			),
			'stealth' => array(
			),
			'is_deleted' => array(
			),
			'sort_order' => array(
			),
			'created_at' => array(
			),
			'updated_at' => array(
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
			'name' => '',
			'manufactor_id' => '',
			'owner_id' => '',
			'enabled' => '',
			'stealth' => '',
			'is_deleted' => '',
			'sort_order' => '',
			'created_at' => '',
			'updated_at' => '',
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
			'name',
			'manufactor_id',
			'owner_id',
			'enabled',
			'stealth',
			'is_deleted',
			'sort_order',
			'created_at',
			'updated_at',
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
			'name' => 'XXXX',
			'manufactor_id' => '',
			'owner_id' => '',
			'enabled' => '1',
			'stealth' => '0',
			'is_deleted' => '1',
			'sort_order' => '',
			'created_at' => '',
			'updated_at' => '',
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
			'name' => 190,
			'manufactor_id' => 11,
			'owner_id' => 11,
			'enabled' => 1,
			'stealth' => 1,
			'is_deleted' => 1,
			'sort_order' => 11,
			'created_at' => 0,
			'updated_at' => 0,
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
			'name' => true,
			'manufactor_id' => false,
			'owner_id' => false,
			'enabled' => false,
			'stealth' => false,
			'is_deleted' => false,
			'sort_order' => false,
			'created_at' => false,
			'updated_at' => false,
		);
		if (!array_key_exists($field, $items)) {
			return 0;
		}
		return $items[$field];
	}
}