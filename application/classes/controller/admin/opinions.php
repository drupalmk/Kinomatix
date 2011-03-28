<?php defined('SYSPATH') or die('No direct script access');

class Controller_Admin_Opinions extends Controller_Admin_Admin {

    private $opinion;

    public function before() {
        parent::before();
        $this->opinion = ORM::factory('opinion');
    }

    public function action_add() {
        $this->process_frm();
    }

    public function action_edit($id) {
        $this->opinion->find(Request::instance()->param('id'));
        if ($this->opinion->loaded()) {
            if ($this->is_admin OR Auth::instance()->get_user()->id == $this->opinion->user->id) {
                $this->process_frm();
            }
        }
    }

    public function action_delete($id) {
        $this->opinion->delete($id);
        $this->set_msg(TRUE);
        $this->request->redirect(Route::get('default')->uri(array('action' => 'opinions')));
    }

    private function process_frm() {
        $this->template->content = View::factory('admin/opinion_frm')
                                   ->bind('opinion', $this->opinion)
                                   ->bind('errors', $errors)
                                   ->set('action', $this->request->action);
        $this->template->scripts = array('media/js/jquery.counter.js');
        if ($_POST) {
            $this->opinion->values($_POST);
            if ($this->opinion->check()) {
                $this->opinion->save();
                $this->set_msg(TRUE);
                $this->request->redirect(Route::get('default')->uri(array('action' => 'opinions')));
            } else {
                $errors = $this->opinion->get_errors();
                $this->set_msg(FALSE);
            }
        }
    }
}
?>
