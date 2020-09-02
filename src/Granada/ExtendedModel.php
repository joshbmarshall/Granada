<?php

namespace Granada;

/**
 * This model should be used to extend the auto-generated models
 *
 * @method array find_pairs(string|null $key, string|null $value) Gets data in array form, as pairs of data for each row in the results. The key and value are the database column to use as the array keys and values
 * @method integer count(string $column) Get the count of the column
 * @method string max(string $column) Will return the max value of the chosen column.
 * @method string min(string $column) Will return the min value of the chosen column.
 * @method string avg(string $column) Will return the average value of the chosen column.
 * @method string sum(string $column) Will return the sum of the values of the chosen column.
 * @method boolean delete_many() Delete all matching records
 * @method boolean fakeDelete() Soft delete by setting the is_deleted flag
 * @method string fieldType(string $field_name) What type of field is this attribute
 * @method string refModel(string $column) The relevant model the field is linked to with foreign key
 * @method string getNamespace() The name of the model namespace
 * @method string getModelname() The relative name of the model
 * @static boolean hasAttribute(string $field) Does this model have this attribute
 * @static mixed model() The starting point for all queries
 *
 */
class ExtendedModel extends Model {

    public function beforeSave() {
    }

    public function beforeSaveNew() {
    }

    public function afterSave() {
    }

    public function afterSaveNew() {
    }

    public function beforeDelete() {
    }

    public function afterDelete() {
    }

    /**
     * The timezone for datetime fields stored in the database
     * @var string
     */
    private static $_database_timezone = 'Etc/UTC';

    /**
     * Set the timezone used for datetime fields in the database
     * @param string $timezone e.g. 'Etc/UTC'
     * @return void
     */
    public static function setDatabaseTimezone($timezone) {
        self::$_database_timezone = $timezone;
    }

    public function __get($property) {
        // Auto-get Chronos variable type
        if (substr($property, -8) == '_chronos') {
            $propertybase = substr($property, 0, -8);
            $datetype = $this->datetype($propertybase);
            if ($datetype) {
                $class = get_class($this);
                if ($datetype['type'] == 'date') {
                    return \Cake\Chronos\Chronos::parse($this->$propertybase);
                } else if ($datetype['timezone_mode'] == 'user') {
                    return \Cake\Chronos\Chronos::parse($this->$propertybase, $class::currentTimezone());
                } else if ($datetype['timezone_mode'] == 'site') {
                    return \Cake\Chronos\Chronos::parse($this->$propertybase, $class::siteTimezone());
                } else {
                    return \Cake\Chronos\Chronos::parse($this->$propertybase, self::$_database_timezone);
                }
            }
            return \Cake\Chronos\Chronos::parse($this->$propertybase);
        }
        $datetype = $this->datetype($property);
        if ($datetype) {
            $rawval = parent::__get($property);
            if (is_null($rawval)) {
                return null;
            }
            $class = get_class($this);
            if ($datetype['type'] == 'time') {
                $date = \Cake\Chronos\Chronos::parse($rawval);
            } else {
                $date = \Cake\Chronos\Chronos::parse($rawval, self::$_database_timezone);
            }
            if ($datetype['type'] == 'date') {
                // No timezone adjustment for date
            } elseif ($datetype['type'] == 'dob') {
                // No timezone adjustment for date of birth
            } elseif ($datetype['timezone_mode'] == 'user') {
                // Timezone adjustment to logged in user
                $date = $date->timezone($class::currentTimezone());
            } elseif ($datetype['timezone_mode'] == 'site') {
                // Timezone adjustment to site default
                $date = $date->timezone($class::siteTimezone());
            }
            if ($datetype['type'] == 'date') {
                return $date->toDateString();
            } elseif ($datetype['type'] == 'dob') {
                return $date->toDateString();
            } elseif ($datetype['type'] == 'datetime') {
                return $date->toDateTimeString();
            } elseif ($datetype['type'] == 'time') {
                return $date->toTimeString();
            }
        }
        $value = parent::__get($property);
        if (is_null($value)) {
            return null;
        }
        // Clean data to correct types for json output etc
        switch ($this->fieldType($property)) {
            case 'boolean':
                return $value ? true : false;
            case 'integer':
                return intval($value);
            default:
                return $value;
        }
    }

    public function __set($property, $value) {

        if (!$value) {
            return NULL;
        }
        $datetype = $this->datetype($property);
        if ($datetype) {
            $class = get_class($this);
            if (is_a($value, '\Cake\Chronos\Chronos')) {
                $date = $value;
            } else {
                if (($value == 'CURRENT_TIMESTAMP') || ($value == 'current_timestamp()')) {
                    $date = \Cake\Chronos\Chronos::now();
                } else {
                    if ($datetype['type'] == 'time') {
                        $value = '2019-01-01 ' . $value;
                    }
                    if ($datetype['type'] == 'dob') {
                        if (strpos($value, '/') === FALSE) {
                            $date = \Cake\Chronos\Chronos::parse($value, 'Etc/UTC');
                        } else {
                            $date = \Cake\Chronos\Chronos::createFromFormat('d/m/Y', $value, 'Etc/UTC');
                        }
                    } else {
                        if ($datetype['timezone_mode'] == 'user') {
                            $date = \Cake\Chronos\Chronos::parse($value, $class::currentTimezone());
                        } else if ($datetype['timezone_mode'] == 'site') {
                            $date = \Cake\Chronos\Chronos::parse($value, $class::siteTimezone());
                        } else {
                            $date = \Cake\Chronos\Chronos::parse($value, self::$_database_timezone);
                        }
                    }
                }
            }
            if ($datetype['type'] == 'date') {
                $value = $date->toDateString();
            } elseif ($datetype['type'] == 'dob') {
                $value = $date->toDateString();
            } elseif ($datetype['type'] == 'datetime') {
                $date = $date->timezone(self::$_database_timezone);
                $value = $date->toDateTimeString();
            } elseif ($datetype['type'] == 'time') {
                $date = $date->timezone('Etc/UTC');
                $value = $date->toTimeString();
            }
        }
        return parent::__set($property, $value);
    }

    public function datefields() {
        return array();
    }

    private function datetype($property) {
        $datefields = $this->datefields();
        if (array_key_exists($property, $datefields)) {
            return $datefields[$property];
        }
        return false;
    }

    /**
     * Check if a date/time field needs timezone adjustment for use in queries
     *
     * @param string $property
     * @param \Cake\Chronos\Chronos $value
     * @return string
     */
    public static function adjustTimezoneForWhere($property, $value) {
        $class = get_called_class();
        $datetype = (new $class)->datetype($property);
        if ($datetype) {
            if ($datetype['type'] == 'date') {
                $timezone = $value->timezone; // No change for date
            } else if ($datetype['timezone_comparison_mode'] == 'user') {
                // If you get an error below, ensure you create this function in your base class that extends ExtendedModel
                // It returns the time zone for the logged in user
                $timezone = $class::currentTimezone();
            } else if ($datetype['timezone_comparison_mode'] == 'site') {
                // If you get an error below, ensure you create this function in your base class that extends ExtendedModel
                // It returns the time zone for the website
                $timezone = $class::siteTimezone();
            } else if ($datetype['timezone_mode'] == 'none') {
                $timezone = $value->timezone; // No timezone, time is time of day regardless of the time zone checking against
            } else {
                $timezone = self::$_database_timezone;
            }

            $value = $value->timezone($timezone)->format($datetype['format']);
        }

        return $value;
    }

    public static function filter_find_pairs_representation($query, $limit = 1000) {
        $modelname = get_called_class();

        $query->select('id');
        foreach ($modelname::representationColumns() as $columnName) {
            $query->select($columnName);
        }
        $query->order_by_expr($modelname::defaultOrder());
        if ($limit) {
            $query->limit($limit);
        }

        $items = $query->find_many();

        $list = array();
        foreach ($items as $item) {
            $list[$item->id] = $item->representation();
        }
        natcasesort($list);
        return $list;
    }

    /**
     * Add query filter for every query for this model
     *
     * @var \Granada\Orm\Wrapper $query
     * @return \Granada\Orm\Wrapper
     */
    public static function filter_defaultFilter($query) {
        $class = get_called_class();
        if ($class::hasAttribute('is_deleted')) {
            $query = $query->where_is_deleted(0);
        }
        if ($class::hasAttribute('enabled')) {
            $query = $query->where_enabled(1);
        }
        if ($class::hasAttribute('stealth')) {
            $query = $query->where_stealth(0);
        }
        return $query;
    }

    /**
     * Save the model, apply before and after save functions
     *
     * @param bool $ignore If the id already exists on insert, do an update instead
     * @return $this
     * @throws \PDOException
     */
    public function save($ignore = false) {
        $isnew = $this->is_new();
        // Check sort order
        if ($this->hasAttribute('sort_order')) {
            if (!$this->sort_order) {
                $this->sort_order = $this->model()->max('sort_order') + 1;
            }
        }

        $doTimestamps = $this->hasAttribute('updated_at');
        if ($doTimestamps) {
            $this->updated_at = \Cake\Chronos\Chronos::now();
        }
        if ($isnew) {
            if ($doTimestamps) {
                $this->created_at = \Cake\Chronos\Chronos::now();
            }
            $this->beforeSaveNew();
        }
        $this->beforeSave();
        parent::save($ignore);
        $this->reload(); // Update all references and changed ids take effect
        $this->afterSave();
        if ($isnew) {
            $this->afterSaveNew();
        }
        return $this;
    }

    /**
     * Delete the record from the database, executing before and after functions
     * @return bool Success
     * @throws \PDOException
     */
    public function delete($for_real = false) {
        $this->beforeDelete();
        if ($this->fakeDelete() && !$for_real) {
            $this->is_deleted = true;
            $success = $this->save() ? true : false;
        } else {
            $success = parent::delete();
        }
        $this->afterDelete();
        return $success;
    }

    /**
     * Load the item again from the database, to refresh the data in case of changes
     * @return void
     */
    public function reload() {
        $new_version = $this->model()->find_one($this->id);
        if ($new_version) {
            $this->orm->hydrate($new_version->as_array());
            $this->relationships = array();
        }
    }

    /**
     * Alias of reload
     *
     * @return void
     */
    public function refresh() {
        $this->reload();
    }

    /**
     * Starting point for rendering this item as a form
     * @return \Granada\Form
     */
    public function getForm($class) {
        return new $class($this);
    }

}
