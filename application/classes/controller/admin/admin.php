<?php defined('SYSPATH') or die('No direct script access');

abstract class Controller_Admin_Admin extends Controller_Site {

    private $allowed = array(
            'login' => array('index'),
            'opinions' => array('add', 'edit'),
            'movies' => array('find', 'rate', 'id'),
            'shows' => array('find', 'upcoming', 'id'),
            'reservation' => array('index')
        );


    public function before() {
        parent::before();
        if (! $this->is_admin) {
            $controller = $this->request->controller;
            $action = $this->request->action;
            if (in_array($controller, array_keys($this->allowed))) {
                if (! in_array($action, $this->allowed[$controller])) {
                    $this->redirect();
                }
            } else {
                $this->redirect();
            }
        }
    }

    private function redirect() {
        $this->request->redirect(Route::get('admin')->uri(array('controller' => 'login')));
    }
}
?>
