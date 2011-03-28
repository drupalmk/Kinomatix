 <?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Login extends Controller_Site {

	public function action_index()	{
            
            if ($this->is_admin == TRUE) {
                $this->request->redirect(Route::get('default')->uri());
            }
            $this->template->page_title = 'Logowanie';
            $this->template->content = View::factory('login')
                    ->bind('post', $post)
                    ->bind('errors', $errors);
            if ($_POST) {
                $post = Validate::factory($_POST)
                        ->filter(TRUE, 'trim')
                        ->rule('username', 'not_empty')
                        ->rule('username', 'min_length', array(5))
                        ->callback('username', array($this, 'do_login'))
                        ->rule('password', 'not_empty')
                        ->rule('password', 'min_length', array(5));

                if ($post->check())  {
                    $this->set_msg(TRUE);
                    $this->request->redirect(Route::get('default')->uri());
                } else {
                    $errors = $post->errors('users');
                    $this->set_msg(FALSE);
                }
            }
	}

	public function do_login(Validate $array, $field)  {
		if (empty($errors) AND isset($array['username']) AND isset($array['password'])) {
			$query = DB::query(Database::SELECT, 'SELECT id, password FROM users WHERE username = :username')
				->bind(':username', $array['username'])
				->execute();
			if (sha1($array['password']) === $query->get('password'))  {
				cookie::set('authorized', $array['username']);
                                $this->session->set('authorized_id', $query->get('id'));
                                return TRUE;
			}
			else  {
				$array->error($field, 'invalid');
                                return FALSE;
			}
		}
	}

}
