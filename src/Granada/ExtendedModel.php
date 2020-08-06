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
}
