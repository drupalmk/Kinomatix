<?php defined('SYSPATH') or die('No direct script access allowed');

    class Model_User extends Model_Auth_User {

        public function __construct()
        {
                $this->_rules['username']['min_length'] = array(3);
                $this->_rules['password']['min_length'] = array(3);
                $this->_has_many = arr::merge($this->_has_many,
                        array('tickets' => array(), 'opinions' => array()));
                parent::__construct();
        }

        public function login(array & $array, $redirect = FALSE) {
            $status = parent::login($array, $redirect);
            $status = $this->confirmed ? TRUE : FALSE;
            return $status;
        }

        public function get_ticket_by_show($show_id) {
            return $this->tickets->where('show_id','=',$show_id)->find();
        }


	public function confirm($user_id, $code)
	{
		$this->find($user_id);

		if ( ! $this->loaded())
		{
			return FALSE;
		}

		if ($this->confirmed)
		{
			return FALSE;
		}

		if ($code !== Auth::instance()->hash_password($this->email, Auth::instance()->find_salt($code)))
		{
			return FALSE;
		}
		$this->confirmed = TRUE;
		$this->save();

		$this->add('roles', ORM::factory('role', array('name' => 'login')));

		return TRUE;
	}

        
    }
?>
