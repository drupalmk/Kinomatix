<?php defined('SYSPATH') or die('No direct script access');

class Model_Show extends Model_Kinomatix {

    protected $_belongs_to = array('movie' => array(), 'cinema' => array());

    protected $_has_many = array(
               // 'places' => array('through' => 'showsplaces'),
                'tickets' => array(),
             );

    protected $_filters = array(
            'start_date' => array(
                            'trim' => NULL,
            ),
    );

    protected $_rules = array(
            'start_date' => array(
                            'not_empty' => NULL,
            )
    );

    protected $_callbacks = array(
            'start_date' => array(
                            'start_date_valid',
            ),
            'end_date' => array(
                            'end_date_valid',
            ),
    );

    public function values($values) {
        $start_date = '';
        foreach($values as $key => $value) {
            if ($key == 'start_day' OR $key == 'start_time') {
                if (is_array($value)) {
                    switch($key) {
                        case 'start_day':
                            $glue = '-';
                            break;
                        case 'start_time':
                            $glue = ':';
                            break;
                    }
                    $value = implode($glue, $value);
                }
                $start_date .= $value.' ';
            }
        }
        $values['start_date'] = strtotime($start_date);
        $this->movie = ORM::factory('movie', (int) $values['movie_id']);
        $duration = $this->movie->duration;
        $values['end_date'] = $values['start_date'] + $duration * 60
                + self::MINUTES_FOR_PEOPLE_TO_TAKE_PLACES * 60;
        $this->cinema = ORM::factory('cinema', (int) $values['cinema_id']);
        parent::values($values);
    }

    public function save() {
        if (empty($this->created)) {
            $this->created = time();
        } else {
            $this->last_modified = time();
        }
        parent::save();
    }

    public function get_upcoming_shows($next_days = 64) {
        $current_time = time();
        $time_in_future = $current_time + 60 * 60 * 24 * $next_days;
        return $this->where('start_date', '>', $current_time)
                ->and_where('start_date', '<=', $time_in_future)
                ->order_by('start_date', 'DESC')->find_all();
    }

//    public function get_places() {
//        $places = ORM::factory('place')->get_rows();
//        $tickets = $this->tickets->find_all();
//        foreach($places as $row) {
//            foreach($row as & $place) {
//               foreach($tickets as $ticket) {
//                   if ($ticket->has('ticketsplaces', $place)) {
//                       $place->set_occupied(TRUE);
//                   }
//               }
//            }
//        }
//        return $places;
//    }

    public function get_reserved_places_id() {
        $places_id = array();
        $tickets = $this->tickets->find_all();
        foreach($tickets as $t) {
            $places_id[] = $t->places->find_all()->as_array('id', 'id');
        }
        return $places_id;
        //return $this->places->find_all()->as_array('id', 'id');
    }

//    public function get_tickets_info($curr_user_id) {
//        $tickets_info = array();
//        foreach($this->tickets->with('user')->find_all() as $ticket) {
//            $info['id'] = $ticket->id;
//            if ($ticket->user->id == $curr_user_id) {
//                $info['status'] = 'current';
//            }
//            $tickets_info[] = $info;
//        }
//    }

    public function get_shows() {
        return $this->order_by('start_date', 'DESC')->find_all();
    }

    public function find_by_date($str_date) {
        $shows = $this->find_all();
        $results = new ArrayObject();
        foreach ($shows as $show) {
            if (strcmp(date('d.m.Y', $show->start_date),$str_date) == 0) {
                $results->append($show);
            }
        }
        return $results;
    }



    public function start_date_valid(Validate $array, $target) {
        if ($array[$target] < time() + 60 * 60 * self::HOURS_FROM_NOW_TO_NEXT_SHOW) {
            $array->error($target, 'date_in_future', array(self::HOURS_FROM_NOW_TO_NEXT_SHOW));
        } else {
            $this->check_date_is_not_occupied($array, $target);
        }
    }

    public function end_date_valid(Validate $array, $target) {
        $this->check_date_is_not_occupied($array, $target);
    }

    private function check_date_is_not_occupied(Validate $array, $target) {
        $query = $this->where($target, 'BETWEEN', DB::expr($array['start_date'].' AND '.$array['end_date']))
                      ->and_where($this->_primary_key, '!=', $this->id)
                      ->and_where('cinema_id', '=',$this->cinema->id);
        $exists = (bool) $query->count_all();
        if ($exists) {
           switch($target) {
                case 'start_date':
                    $params[] = self::HOURS_FROM_NOW_TO_NEXT_SHOW;
                    break;
                case 'end_date':
                    $params[] = self::MINUTES_FOR_PEOPLE_TO_TAKE_PLACES;
                    break;
            }
            $array->error($target, $target.'_free', $params);
        }
    }

    CONST MINUTES_FOR_PEOPLE_TO_TAKE_PLACES = 30;
    CONST HOURS_FROM_NOW_TO_NEXT_SHOW = 6;
    
}
?>
