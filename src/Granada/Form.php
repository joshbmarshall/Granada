<?php

namespace Granada;

class Form {

    /**
     * @var \Granada\ExtendedModel
     */
    private $model;

    public function __construct($model) {
        $this->model = $model;
    }

    public function getFields($field_names = null) {
        if (is_null($field_names)) {
            $field_names = $this->model->formFields();
        }
        $fields = array();
        foreach ($field_names as $field_name) {
            $fields[] = $this->getField($field_name);
        }
        return $fields;
    }

    public function getField($field_name) {
        return array(
            'type' => $this->model->fieldType($field_name),
            'name' => $field_name,
            'value' => $this->model->$field_name,
            'tags' => $this->model->fieldTags($field_name),
            'helptext' => $this->model->fieldHelpText($field_name),
            'length' => $this->model->fieldLength($field_name),
            'required' => $this->model->fieldIsRequired($field_name),
        );
    }
}
