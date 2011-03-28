<?php defined('SYSPATH') or die('No direct script access allowed');

class Model_New extends Model_Kinomatix {

    protected $_belongs_to = array('user' => array());

    protected $_filters = array(
        'title' => array(
            'trim' => NULL,
        ),
        'content' => array(
            'trim' => NULL,
        )
    );

    protected $_rules = array(
        'title' => array(
            'not_empty' => NULL,
            'min_length' => array(3),
            'max_length' => array(100),
        ),
        'content' => array(
            'not_empty' => NULL,
            'min_length' => array(10),
            'max_length' => array(4000),
        )
    );

   protected $_callbacks = array(
        'title' => array('unique'),
    );

   public function get_news() {
       return $this->order_by('created', 'DESC')->find_all();
   }

   public function save() {
       $this->user = Auth::instance()->get_user();
       if (empty($this->created)) {
           $this->created = time();
       } else {
           $this->last_modified = time();
       }
       parent::save();
   }
}
?>
