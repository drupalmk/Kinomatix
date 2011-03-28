<?php defined('SYSPATH') or die('No direct script access allowed');

class Model_Place extends Model_Kinomatix {

    protected $_has_many = array(
                //'shows' => array('through' => 'showsplaces'),
                'tickets' => array('through' => 'placestickets')
              );

//    private $is_occupied = FALSE;

//    public $belongs_to_curr_user = FALSE;

//    public function is_occupied() {
//        return $this->is_occupied;
//    }
//
//    public function occupied() {
//        $this->is_occupied = TRUE;
//    }

    public function get_places() {
        $curr_row_id = 'a';
        foreach($this->find_all() as $place) {
            $row_id = substr($place->code, 0, 1);
            if (strcmp($curr_row_id, $row_id) != 0) {
                $curr_row_id = $row_id;
            }
            $rows[$curr_row_id][] = $place;
        }
        return $rows;
    }
}
?>
