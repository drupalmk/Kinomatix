<?php defined('SYSPATH') or die('No direct script access allowed');

class Model_Maker extends Model_Kinomatix {

    protected $_has_many = array('movies' => array('through' => 'moviesmakers'));

    protected $_filters = array(
        'name' => array('trim' => NULL),
    );

    protected $_rules = array(
      'name' => array(
          'not_empty' => NULL,
          'min_length' => array(5),
          'max_length' => array(100),
      ),
    );

   public function save() {
        if (empty($this->created)) {
            $this->created = time();
        } else {
            $this->last_modified = time();
        }
        parent::save();
        $this->reload();
    }

    public function find_maker($name, $type = 1) {
        return $this->where('name', 'LIKE', '%'.$name.'%')->and_where('type', '=', (int) $type)->find_all();
    }

    public function get_makers() {
        return $this->order_by('last_modified', 'DESC')->find_all();
    }

    public function get_actor_by_name($name) {
        return $this->get_by_name($name, 2);
    }

    public function get_director_by_name($name) {
        return $this->get_by_name($name, 1);
    }

    public function get_screenwriter_by_name($name) {
        return $this->get_by_name($name, 3);
    }

    private function get_by_name($name, $type) {
        return $this->where('name', '=', $name)->and_where('type', '=', $type)->find();
    }
}
?>
