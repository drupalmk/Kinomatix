<?php defined('SYSPATH') or die('No direct script access allowed');

class Controller_Admin_News extends Controller_Site {

    private $news;

    public function before() {
        parent::before();
        $this->news = ORM::factory('new');
    }

    public function action_add() {
        $this->process_frm();
    }

    public function action_edit($id) {
        $this->news->find($id);
        $this->process_frm();
    }

    public function action_delete($id) {
        $this->news->delete($id);
        $this->set_msg(TRUE);
        $this->request->redirect(Route::get('default')->uri());
    }

    private function process_frm() {
        $this->template->content = View::factory('admin/news_frm')
                                   ->bind('news', $this->news)
                                   ->bind('errors', $errors);
        $this->template->scripts = array('media/js/jquery.counter.js');
        if ($_POST) {
            $this->news->values($_POST);
            if ($this->news->check()) {
                $this->news->save();
                $this->set_msg(TRUE);
                $this->request->redirect(Request::instance()->uri);
            } else {
                $errors = $this->news->get_errors();
                $this->set_msg(FALSE);
            }
        }
    }
    
}
?>
