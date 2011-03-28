<?php defined('SYSPATH') or die('No direct script access allowed');

class Model_Ticket extends Model_Kinomatix {

    protected $_belongs_to = array('show' => array(), 'user' => array());

    protected $_has_many = array('places' => array(
                                        'through' => 'ticketplaces',
                                ));

    
    public function get_by_code($code) {
        return $this->where('code', '=', $code)->find();
    }

    public function get_places_count() {
        return $this->places->count_all();
    }

    public function get_places() {
        return $this->places->find_all();
    }

    public function add_place($place_id) {
        $this->add('places', ORM::factory('place', (int) $place_id));
    }

    public function add_places(array $places_id) {
        foreach($places_id as $id) {
            $this->add_place($id);
        }
    }

    public function compute_price($places) {
        $amount = is_array($places) ? sizeof($places) : 1;
        $price = (bool) $this->type ? 16 : 20;
        $this->price = $amount * $price;
    }

    public function get_places_id() {
        return $this->places->find_all()->as_array('id','id');
    }

    public function save() {
        if (empty($this->code)) {
            $this->code = uniqid();
        }
        $this->user = Auth::instance()->get_user();
        parent::save();
    }
}
?>
