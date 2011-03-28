<?php defined('SYSPATH') or die('No direct script access allowed');

class Model_Rate extends Model_Kinomatix  {

    protected $_has_many = array('movies' => array());

    public function  __construct($id = NULL, $movie_id = NULL) {
        parent::__construct($id);
        if (isset($movie_id)) {
            $this->where('movie_id', '=', $movie_id)->find();
            if (! $this->loaded()) {
                $this->movie_id = $movie_id;
            }
        }
    }

    public function get_avg_rate() {
        return $this->count ? round($this->total / $this->count, 1) : 0;
    }

    public function add_rate($rate) {
        $this->count += 1;
        $this->total += $rate;
        $this->save();
    }

    public function get_rates_count() {
        return $this->count;
    }

    public function get_top_rates() {
        return $this->order_by('total', 'DESC')->limit(10)->find_all();
    }
}
?>
