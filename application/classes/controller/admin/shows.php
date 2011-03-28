<?php defined('SYSPATH') or die('No direct script access allowed');

class Controller_Admin_Shows extends Controller_Admin_Admin {

    private $show;

    public function before() {
        parent::before();
        $this->show = ORM::factory('show');
    }

    public function action_id($id) {
        $shows = new ArrayObject();
        $shows->append(ORM::factory('show', $id));
        $this->template->content = View::factory('shows')
                                   ->set('shows', $shows);
    }

    public function action_add() {
        $this->process_frm();
    }

    public function action_edit($id) {
        $this->show->find($id);
        $this->process_frm();
    }

    public function action_delete($id) {
        $this->show->delete((int) $id);
        $this->set_msg(TRUE);
        $this->redirect_to_prev_uri();
    }

    public function action_find() {
            $this->template->content = View::factory('shows')
                                       ->set('shows', $this->show->find_by_date($_GET['search']));
        
    }

    public function action_upcoming() {
        $this->template->content = View::factory('shows')
                                   ->set('shows', $this->show->get_upcoming_shows());
    }

    private function process_frm() {
        $this->template->content = View::factory('admin/show_frm')
                                   ->bind('show', $this->show)
                                   ->bind('errors', $errors)
                                   ->set('shows', $this->show->get_shows())
                                   ->set('cinemas', ORM::factory('cinema')->get_cinemas())
                                   ->set('movies', ORM::factory('movie')->find_all());
        $this->template->scripts = array('media/js/jquery.counter.js', 
                                         );

        if ($_POST) {
            $this->show->values($_POST);
            if (($is_success = $this->show->check())) {
                $this->show->save();
                $this->set_msg(TRUE);
                $this->request->redirect(Route::get('shows')->uri(array('action' => 'add')));
            } else {
                $errors = $this->show->get_errors();
                $this->set_msg(FALSE);
            }
        }
    }
}
?>
