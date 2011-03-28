<?php defined('SYSPATH') or die('No direct script access.');

class Form extends Kohana_Form {
    
    public static function show_errors(& $errors) {
        if (! empty($errors)) {
            echo '<div class="validation"><ul>';
            foreach ($errors as $key => $error) {
                echo '<li><label for="'.$key.'">'.$error.'</label></li>'.PHP_EOL;
            }
            echo '</ul></div>';
        }
    }

    public static function value($model, $key) {
        if (! empty($model->$key)) {
            return $model->$key;
        } else if (isset($_POST[$key])) {
            return $_POST[$key];
        } else return NULL;
    }
}
