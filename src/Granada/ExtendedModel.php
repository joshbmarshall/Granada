<?php

namespace Granada;

/**
 * This model should be used to extend the auto-generated models
 */
class ExtendedModel extends Model {

    public function __get($property) {
        if (substr($property, -8) == '_chronos') {
            $propertybase = substr($property, 0, -8);
            return \Cake\Chronos\Chronos::parse($this->$propertybase);
        }
        return parent::__get($property);
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
        $datefields = $class::datefields();
        if (!array_key_exists($property, $datefields)) {
            $property = (new $class)->tablename() . '.' . $property;
        }
        if (array_key_exists($property, $datefields)) {
            if ($datefields[$property]['type'] == 'date') {
                $timezone = $value->timezone; // No change for date
            } else if ($datefields[$property]['timezone_comparison_mode'] == 'user') {
                $timezone = self::currentTimezone();
            } else if ($datefields[$property]['timezone_comparison_mode'] == 'site') {
                $timezone = self::siteTimezone();
            } else if ($datefields[$property]['timezone_mode'] == 'none') {
                $timezone = $value->timezone; // No timezone, time is time of day regardless of the time zone checking against
            } else {
                $timezone = 'Etc/UTC';
            }

            $format = $datefields[$property]['format'];

            $value = $value->timezone($timezone)->format($format);
        }

        return $value;
    }
}
