<?php defined('SYSPATH') or die('No direct script access allowed');

class Controller_Admin_Makers extends Controller_Site {

    private $maker;

    public function before() {
        parent::before();
        $this->maker = ORM::factory('maker');
    }

    public function action_add() {
        $this->process_frm();
    }

//    public function action_edit($id) {
//        $this->maker->find($id);
//        $this->process_frm();
//    }
//
//    public function action_delete($id) {
//        $this->maker->delete($id);
//        $this->set_msg(TRUE);
//        $this->request->redirect(Route::get('default')->uri());
//    }
    public function action_find() {
        $search_value = trim($_GET['search']);
        $type = isset($_GET['type']) ? $_GET['type'] : NULL;
        $makers = $this->maker->find_maker($search_value, $type);
        if ($this->is_ajax) {
            $result = array();
            foreach($makers as $maker) {
                $result[]['name'] = $maker->name;
            }
            echo json_encode($result);
        } else {

        }
        
    }
    private function process_frm() {
        $this->template->content = View::factory('admin/maker_frm')
                                   ->bind('maker', $this->maker)
                                   ->bind('errors', $errors)
                                   ->set('makers', ORM::factory('maker')->find_all());
        $this->template->scripts = array('media/js/jquery.counter.js');
        if ($_POST) {
            $this->maker->values($_POST);
            if (($is_success = $this->maker->check())) {
                $this->maker->save();
                $this->request->redirect(Request::instance()->uri);
            } else {
                $errors = $this->maker->get_errors();
            }
            $this->set_msg($is_success);
        }
    }
}
?>
