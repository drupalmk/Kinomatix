<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Index extends Controller {

	public function action_index()
	{
		$this->request->response = View::factory('template')->render();
	}

} // End Welcome
