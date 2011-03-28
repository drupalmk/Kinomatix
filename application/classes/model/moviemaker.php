<?php defined('SYSPATH') or die('No direct script access');

class Model_MovieMaker extends Model_Kinomatix {

    protected $_filters = array(
        TRUE => array(
            'trim' => NULL,
        ),
    );

    protected $_rules = array(
        'name' => array(
            'not_empty' => NULL,
            'min_length' => array(2),
            'max_length' => array(50),
        ),
        'surname' => array(
            'not_empty' => NULL,
            'min_length' => array(2),
            'max_length' => array(50),
        ),
    );

    public function save() {
        if (empty($this->created)) {
            $this->created = time();
        }
        parent::save();
    }

    public function get_by_type($type) {
        return $this->where('type', '=', $type)->find_all();
    }
}
?>
