<?php defined('SYSPATH') or die('No direct script access allowed');

class Model_Kinomatix extends ORM {

    protected $errors_filename = '';

    protected $message;

    public function  __construct($id = null) {
        $this->errors_filename = Inflector::plural(str_replace('Model_', '', get_class($this)));
        parent::__construct($id);
    }

    public function unique(Validate $array, $target) {
                $query = $this->where($target, '=', $array[$target]);
                if (Request::instance()->action == 'edit') {
                    $query->and_where('id', '!=', $this->id);
                }
                $exists = (bool) $query->count_all();

		if ($exists) {
			$array->error($target, 'unique');
                }
    }

    public function get_errors() {
        return $this->_validate->errors($this->errors_filename);
    }
}
?>
