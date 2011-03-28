<?php defined('SYSPATH') or die('No direct script access');
class Controller_Admin_Logout extends Controller {

	public function __construct(Request $request)   {

		cookie::delete('authorized');
                Session::instance()->regenerate();
                Session::instance()->delete('authorized_id');
                Session::instance()->set('message', array('type' => 'info', 'message' => 'Wylogowano.'));
		$request->redirect('');
                
	}

}

?>
