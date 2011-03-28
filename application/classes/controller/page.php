<?php defined('SYSPATH') or die('No direct script access');

    class Controller_Page extends Controller_Site {

  

        public function action_home() {
            $this->template->page_title = 'Aktualności';
            $this->template->content = View::factory('news')
                                       ->set('news', ORM::factory('new')->get_news());
        }

        public function action_opinions() {
            $this->template->page_title = 'Opinie o nas';
            $this->template->content = View::factory('opinions')
                                        ->set('opinions', ORM::factory('opinion')->get_opinions())
                                        ->set('form', View::factory('admin/opinion_frm')
                                                ->set('form_title', 'Twoja opinia')
                                                ->set('legend', 'Dodaj swoją opinię')
                                                ->set('action', 'add')
                                                ->set('opinion', ORM::factory('opinion'))
                                        );
            if (! $this->is_user) {
                $this->session->set('message', array('message' => 'Zaloguj się, aby mieć możliwość wystawienia opinii', 'type' => 'info'));
            }
        $this->template->scripts = array('media/js/jquery.counter.js');

        }
    }
?>
