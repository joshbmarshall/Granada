<?php

namespace MyAppTest;

class Car extends BaseCar {

    public static function filter_byName($query, $name) {
        return $query->where('name', $name);
    }

    public static function _defaultFilter($query) {
        return $query->where('car.is_deleted', 0);
    }

}
