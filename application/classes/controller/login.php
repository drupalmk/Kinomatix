<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Login extends Controller_Site {

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
                        ->rule('username', 'regex', array('/^[\pL]{4,24}$/iu'))
                        ->callback('username', array($this, 'do_login'))
                        ->rule('password', 'not_empty')
                        ->rule('password', 'min_length', array('5'));

                if ($post->check($errors))  {
                        $this->set_message('success', 'Zalogowano z powodzeniem.');
                        $this->request->redirect(Route::get('default')->uri());
                } else {
                    $this->set_message('warning', 'Przekazano niepoprawne dane.');
                }
            }
	}

	public function do_login(Validate $array, $field, array $errors)  {
		if (empty($errors) AND isset($array['username']) AND isset($array['password'])) {
			$query = DB::query(Database::SELECT, 'SELECT password FROM admin WHERE username = :username')
				->bind(':username', $array['username'])
				->execute();

			if (sha1($array['password']) === $query->get('password'))  {
				cookie::set('authorized', $array['username']);
			}
			else  {
				$errors['username'] = 'Niepoprawna nazwa użytkownika lub hasło.';
			}
		}

		return $errors;
	}

}
