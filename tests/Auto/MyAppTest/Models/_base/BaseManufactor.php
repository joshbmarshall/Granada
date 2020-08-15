<?php

/**
 * This is the base model class for the database table 'manufactor'
 *
 * Do not modify this file, it is overwritten via the db2model script
 * If any changes are required, override them in the 'MyAppTest\Manufactor' class.
 */

namespace MyAppTest;

/**
 * @property integer $id
 * @property string $name
 * @property \MyAppTest\Car[] $cars
 *
 * @method \MyAppTest\Manufactor save(boolean $ignore = false) Save and reload the model, optionally ignoring existing id (Use INSERT ON DUPLICATE KEY UPDATE query).
 */
abstract class BaseManufactor extends \MyAppTest\ORMBaseClass {
    public static $_table = 'manufactor';

	/**
	 * Starting point for all queries
	 * @return \MyAppTest\QueryManufactor
	 */
	public static function model() {
		return \Granada\Granada::factory('MyAppTest\Manufactor');
	}

    public function cars() {
        return $this->has_many('MyAppTest\Car', 'manufactor_id')->defaultFilter()->order_by_expr(\MyAppTest\Car::defaultOrder());
    }

    /**
     * Get the field name of the Car that links back to this Manufactor
     * @return string
     */
    public function cars_refVar() {
            return 'manufactor_id';
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
		return 'Manufactor';
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
		return 'manufactor';
	}

	/**
	 * Get the human-readable name for the model
	 *
	 * @return string
	 */
	public static function humanName() {
		return 'Manufactor';
	}

	/**
	 * Get the plural version of human-readable name for the model
	 *
	 * @return string
	 */
	public static function humanNames() {
		return \Granada\Autobuild::pluralize('Manufactor');
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
		return 'name';
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
		));
	}

	/**
	 * Set attributes for an item in bulk
	 * Array has the property name as the keys
	 *
	 * @param array $data
	 * @return \MyAppTest\Manufactor
	 */
	public function setAttributes($data) {
		foreach ($data as $key => $val) {
			if (\MyAppTest\Manufactor::hasAttribute($key) && $this->{$key} !== $val) {
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
			'name' => array(
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
			'name' => '',
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
		);
		if (!array_key_exists($field, $items)) {
			return 0;
		}
		return $items[$field];
	}
}