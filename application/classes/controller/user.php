<?php defined('SYSPATH') or die('No direct script access');

    class Controller_User extends Controller_Site {
        
        public function action_register()
        {
                if (Auth::instance()->logged_in())
                {
                        Request::instance()->redirect('');
                }
                $this->template->content = View::factory('register')
                        ->bind('post', $post)
                        ->bind('errors', $errors)
                        ->set('title', 'Rejestracja');
                if ($_POST)
                {
                        $post = $_POST;

                        $user = ORM::factory('user');
                        $user->values($post);

                        if ($user->check())
                        {
                                //Auth::instance()->force_login($post['username']);
                                $user->save();
                                $body = View::factory('register_mail', $user->as_array())
                                        ->set('code', Auth::instance()->hash_password($user->email))
                                        ->render();
                                require Kohana::find_file('vendor', 'swiftmailer/swift_required');
                                $message = Swift_Message::newInstance()
                                        ->setSubject('Rejestracja w Kinomatix')
                                        ->setFrom(array('tua1@interia.pl' => 'kinomatix.com'))
                                        ->setTo(array($user->email => $user->username))
                                        ->setBody($body);

                                $transport = Swift_SmtpTransport::newInstance('poczta.interia.pl')
                                        ->setUsername('tua1@interia.pl')
                                        ->setPassword('blackhawkdown');

                                Swift_Mailer::newInstance($transport)->send($message);
                                $this->set_msg(TRUE);
                                Request::instance()->redirect('');
                        }
                        else
                        {
                                $this->set_msg(FALSE);
                                $errors = $user->validate()->errors('user');
                        }
                }
        }

                public function action_login()
                {
                        if (Auth::instance()->logged_in())
                        {
                                Request::instance()->redirect('');
                        }
                        $this->template->content = View::factory('login')
                                ->bind('post', $post)
                                ->bind('errors', $errors);
                        if ($_POST)
                        {
                                $post = $_POST;
                                $user = ORM::factory('user');

                                if ($user->login($post))
                                {
                                        Request::instance()->redirect('');
                                }
                                else
                                {
                                        $errors = $post->errors('user');
                                        
                                }
                        }
                }

                public function action_logout()
                {
                        if ( ! Auth::instance()->logged_in())
                        {
                                Request::instance()->redirect('');
                        }
                        Auth::instance()->logout();
                        Request::instance()->redirect('');
                }

                public function action_confirm()
                {
                        $user = ORM::factory('user');
                        if ($user->confirm($this->request->param('id'), $this->request->param('code')))
                        {
                            Auth::instance()->force_login($user->username);
                            $this->set_msg(TRUE);
                        }
                        else
                        {
                            $this->set_msg(FALSE);
                        }
                        Request::instance()->redirect('');

                }

                public function action_password()
                {
                        if ( ! Auth::instance()->logged_in())
                        {
                                Request::instance()->redirect('');
                        }
                        $this->template->content = View::factory('user/password')
                                ->bind('post', $post)
                                ->bind('errors', $errors);
                        if ($_POST)
                        {
                                $post = $_POST;

                                $user = Auth::instance()->get_user();

                                if ($user->change_password($post))
                                {
                                        echo 'Password changed.';
                                }
                                else
                                {
                                        $errors = $post->errors();
                                }
                        }
                }
    }
?>
