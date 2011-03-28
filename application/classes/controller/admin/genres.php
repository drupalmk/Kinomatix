<?php defined('SYSPATH') or die('No direct script access allowed');

class Controller_Admin_Genres extends Controller_Admin_Admin {

    private $genre;

    public function before() {
        parent::before();
        $this->genre = ORM::factory('genre');
    }

    public function action_add() {
        $this->process_frm();
    }

    public function action_edit() {
        $this->genre->find($this->request->param('id'));
        $this->process_frm();
    }

    public function action_delete($id) {
        $this->genre->delete($id);
        $this->set_msg(TRUE);
        $this->request->redirect(Route::get('admin')->uri(array('controller' => 'genres', 'action' => 'add')));
    }

    private function process_frm() {
        $this->template->content = View::factory('admin/genre_frm')
                                   ->bind('genre', $this->genre)
                                   ->bind('errors', $errors)
                                   ->set('genres', ORM::factory('genre')->get_genres());
        $this->template->scripts = array('media/js/jquery.counter.js');
        if ($_POST) {
            $this->genre->values($_POST);
            if ($this->genre->check()) {
                $this->genre->save();
                $this->set_msg(TRUE);
                $this->request->redirect(Route::get('admin')->uri(array('controller' => 'genres', 'action' => 'add')));
            } else {
                $errors = $this->genre->get_errors();
                $this->set_msg(FALSE);
            }
        }
    }
    
}
?>
