<?php defined('SYSPATH') or die('No direct script access');

class Model_Opinion extends Model_Kinomatix {

    protected $_belongs_to = array('user' => array());

    protected $_filters = array(
       TRUE => array(
            'trim' => NULL,
        ),
    );

    protected $_rules = array(
        'content' => array(
            'not_empty' => NULL,
            'min_length' => array(10),
            'max_length' => array(1000),
        ),
    );

   public function get_opinions() {
       return $this->order_by('created', 'DESC')->find_all();
   }

    public function save() {
        if (empty($this->created)) {
            $this->created = time();
        }
        $this->user = Auth::instance()->get_user();
        parent::save();
    }
}
?>
