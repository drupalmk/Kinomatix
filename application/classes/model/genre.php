<?php defined('SYSPATH') or die('No direct script access allowed');


class Model_Genre extends Model_Kinomatix {

    protected $_has_many = array('movies' => array());

    protected $_filters = array(
        TRUE => array('trim' => NULL),
    );

    protected $_rules = array(
        'name' => array(
            'not_empty' => NULL,
            'min_length' => array(5),
            'max_length' => array(100),
        )
    );

   protected $_callbacks = array(
        'name' => array('unique'),
    );

   public function save() {
       if (empty($this->created)) {
           $this->created = time();
       } else {
           $this->last_modified = time();
       }
       parent::save();
   }

   public function get_genres() {
       return $this->order_by('last_modified', 'DESC')->find_all();
   }
}
?>
