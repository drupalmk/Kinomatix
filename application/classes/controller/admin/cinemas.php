<?php defined('SYSPATH') or die('No direct script access allowed');

    class Controller_Admin_Cinemas extends Controller_Admin_Admin {

        private $_cinema;

        public function before() {
            parent::before();
            $this->_cinema = ORM::factory('cinema');
        }

        public function action_list() {
            $this->template->content = View::factory('cinemas')
                    ->set('cinemas', $this->_cinema->get_cinemas());
        }

        public function action_add() {
            $this->process_frm();
        }

        public function action_edit($id) {
            $this->_cinema->find(Request::instance()->param('id'));
            $this->process_frm();
        }

        public function action_delete($id) {
            $this->_cinema->delete(Request::instance()->param('id'));
            $this->set_msg(TRUE);
            $this->redirect_to_prev_uri();
        }

        private function process_frm() {
            $this->template->content = View::factory('admin/cinema_frm')
                                       ->bind('cinema', $this->_cinema)
                                       ->bind('errors', $errors)
                                       ->set('cinemas', $this->_cinema->get_cinemas())
                                       ->set('provinces', ORM::factory('province')->find_all());
            $this->template->scripts = array('media/js/jquery.counter.js',);
            if ($_POST) {
                $this->_cinema->values($_POST);
                if (($is_success = $this->_cinema->check())) {
                    $this->_cinema->save();
                    $this->set_msg(TRUE);
                    $this->request->redirect(Route::get('cinemas')->uri(array('action' => 'list')));
                } else {
                    $errors = $this->_cinema->get_errors();
                    $this->set_msg(FALSE);
                }
            }
            }
    }

?>
