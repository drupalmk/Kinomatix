<?php defined('SYSPATH') or die('No direct script access');

    abstract class Controller_Site extends Controller_Template {

        protected $is_admin = FALSE;

        protected $is_user = FALSE;

        protected $is_ajax;

        protected $session;

        public function before() {
            parent::before();
            if (Request::$is_ajax) {
                $this->auto_render = FALSE;
                $this->is_ajax = TRUE;
            }
            $this->session = Session::instance('database');
            Auth::instance()->auto_login();
            if (Auth::instance()->logged_in()) {
                $roles = Auth::instance()->get_user()->roles->find_all();
                foreach($roles as $role) {
                    if ($role->name == 'login') {
                        $this->is_user = TRUE;
                    } elseif($role->name == 'admin') {
                        $this->is_admin = TRUE;
                    }
                }
            }
            if ($this->auto_render) {
                $this->template->movies = ORM::factory('movie')->get_top_movies();
                $this->template->shows = ORM::factory('show')->get_upcoming_shows();
                $this->template->page_title = '';
                $this->template->message = '';
                $this->template->content = '';
                $this->template->styles = array();
                $this->template->scripts = array();
                $this->template->set_global('is_admin', $this->is_admin);
                $this->template->set_global('is_user', $this->is_user);
            }
            FirePHP_Profiler::instance()
            ->group('Profiler')
            ->post()
            ->get()
            ->session()
            ->cookie()
            ->database()
            ->benchmark()
            ->groupEnd();
        }

        public function after() {

            if ($this->auto_render) {
                $styles = array(
                    'media/css/main.css',
                    'media/css/ui-lightness/jquery-ui.css'
                );
                $scripts = array('media/js/jquery-ui.min.js');
                $this->template->scripts = array_merge($this->template->scripts, $scripts);
                $this->template->styles = array_merge($this->template->styles, $styles);
                if (($message = $this->session->get('message')) !== NULL) {
                    $this->template->message = View::factory('message')
                                               ->set('type', $message['type'])
                                               ->set('message', $message['message']);
                    $this->session->delete('message');
                }
                $this->session->set('PREV_URI', str_replace(url::base(), '', $_SERVER['REQUEST_URI']));
            }

            parent::after();
        }

        protected function set_msg($is_success) {
            $msg_group = $this->request->controller;
            $msg_name = $this->request->action;
            if ($is_success) {
                $msg_type = '.success.';
                $box_type = 'success';
            } else {
                $msg_type = '.fail.';
                $box_type = 'warning';
            }
            $msg = Kohana::message('messages', $msg_group.$msg_type.$msg_name);
            $this->session->set('message', array('message' => $msg, 'type' => $box_type));
        }

        protected function redirect_to_prev_uri() {
            $this->request->redirect($this->session->get('PREV_URI'));
        }
    }
?>
