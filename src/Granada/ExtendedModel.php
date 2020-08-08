<?php

namespace Granada;

/**
 * This model should be used to extend the auto-generated models
 */
class ExtendedModel extends Model {

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
                    return \Cake\Chronos\Chronos::parse($this->$propertybase, 'Etc/UTC');
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
                $date = \Cake\Chronos\Chronos::parse($rawval, 'Etc/UTC');
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
        return parent::__get($property);
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
                            $date = \Cake\Chronos\Chronos::parse($value);
                        } else if ($datetype['timezone_mode'] == 'site') {
                            $date = \Cake\Chronos\Chronos::parse($value, $class::siteTimezone());
                        } else {
                            $date = \Cake\Chronos\Chronos::parse($value, 'Etc/UTC');
                        }
                    }
                }
            }
            if ($datetype['type'] == 'date') {
                $value = $date->toDateString();
            } elseif ($datetype['type'] == 'dob') {
                $value = $date->toDateString();
            } elseif ($datetype['type'] == 'datetime') {
                $date = $date->timezone('Etc/UTC');
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
                $timezone = 'Etc/UTC';
            }

            $value = $value->timezone($timezone)->format($datetype['format']);
        }

        return $value;
    }
}
