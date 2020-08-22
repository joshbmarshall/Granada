<?php

namespace Granada;

class FormBootstrap4 extends Form {

    public function wrapperTemplate() {
        ob_start();
?>
        <div class="form-group row">
            <label for="{{ label_for }}" class="col-sm-2 col-form-label">{{ label }}{{ help }}</label>
            <div class="col-sm-10">
                {{ content|raw }}
            </div>
        </div>
<?php
        return ob_get_clean();
    }

    public function fieldTemplate($type, $length, $tags) {
        if ($type == 'submit') {
            return '<input type="submit" name="{{ name }}" value="{{ value }}" class="btn btn-default" />';
        }
        if ($type == 'date') {
            return '<input type="date" name="{{ name }}" value="{{ value }}" class="form-control" />';
        }
        return '<input type="text" name="{{ name }}" value="{{ value }}" class="form-control" />';
        return parent::fieldTemplate($type, $length, $tags);
    }
}
