<?php

namespace MyAppTest;

class CarPart extends BaseCarPart {
    public function beforeSaveNew() {
        $this->part_id = 3;
    }

    public function beforeSave() {
        $this->car_id = 4;
    }

    public function afterSaveNew() {
        $this->car->name = 'Is Car Created';
        $this->car->save();
    }

    public function afterSave() {
        $this->car->name = 'Is Car Saved';
        $this->car->save();
    }

    public function beforeDelete() {
        $this->car->name = 'Before Delete';
        $this->car->save();
    }

    public function afterDelete() {
        $part = \MyAppTest\Part::model()->find_one(1);
        $part->name = 'After Delete';
        $part->save();
    }
}
