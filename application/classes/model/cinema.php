<?php defined('SYSPATH') or die('No direct script access');

    class Model_Cinema extends Model_Kinomatix {
      
      //protected $_has_many = array('makers' => array('through' => 'moviesmakers'));
      protected $_has_many = array('shows' => array());
      protected $_belongs_to = array('province' => array());

      protected $_filters = array(
            'name' => array(
                'trim' => NULL,
            ),
            'address' => array(
                'trim' => NULL,
            ),
            'city' => array(
                'trim' => NULL,
            )
      );

      protected $_rules = array(
            'name' => array(
                'not_empty' => NULL,
                'min_length' => array(2),
                'max_length' => array(100),
            ),
            'address' => array(
                'not_empty' => NULL,
                'min_length' => array(2),
                'max_length' => array(100),
            ),
            'city' => array(
                'not_empty' => NULL,
                'min_length' => array(2),
                'max_length' => array(100),
            ),
            'phone' => array(
                'not_empty' => NULL,
                'digit' => NULL,
            ),
       );

    public function values($values) {
        parent::values($values);
        $this->province = ORM::factory('province', (int) $values['province_id']);
    }

    public function get_cinemas() {
        return $this->find_all();
    }
}

?>
