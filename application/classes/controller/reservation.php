<?php defined("SYSPATH") or die("No direct script access allowed");

class Controller_Reservation extends Controller_Site {

    private $place;
    private $show;
    private $ticket;
    private $user;

    public function before() {
        parent::before();
        if (! $this->is_user AND ! $this->is_admin) {
            $this->session->set('message', array('message' => 'Musisz być zalogowany, aby móc rezerwować miejsca.'
                                , 'type' => 'info'));
            $this->request->redirect(Route::get('user')->uri(array('action' => 'login')));
        }
        $this->place = ORM::factory('place');
        $this->show = ORM::factory('show', $this->request->param('id'));
        $this->user = ORM::factory('user')->find(Auth::instance()->get_user()->id);
        $this->ticket = $this->user->get_ticket_by_show($this->show->id);
    }

    public function action_show() {
        if (! $this->ticket->loaded()) {
            $this->ticket->type = 0;
        }

        $this->template->content = View::factory('places')
                                   ->set('places', $this->place->get_places())
                                   ->set('show', $this->show)
                                   ->bind('ticket', $this->ticket)
                                   ->set('movie', $this->show->movie);
        if ($_POST) {
            if (isset($_POST['type-change'])) {
                $this->ticket->type = (int) $_POST['type'];
                return;
            }
            $this->ticket->values($_POST);
            $post = Validate::factory($_POST)
                         ->callback('place', array($this, 'check_place_amount'));
            if ($post->check()) {
                $this->ticket->show = $this->show;
                $this->ticket->compute_price($_POST['place']);
                $this->ticket->save();
                $this->ticket->reload();
                $old_places_id = $this->ticket->get_places_id();
                $places = new ArrayObject();
                $posted_places = $_POST['place'];
                if (is_array($posted_places)) {
                    foreach($posted_places as $id) {
                        $this->add_reservation($id, $places);
                    }
                    foreach($old_places_id as $old_id) {
                        if (! in_array($old_id, $posted_places)) {
                            $this->ticket->remove('places', ORM::factory('place', $old_id));
                        }
                    }
                } else {
                    $this->add_reservation($posted_places, $places);
                    if (! empty($old_places_id)) {
                        if ($posted_places != ($old_id =array_pop($old_places_id))) {
                            $this->ticket->remove('places', ORM::factory('place', $old_id));
                        }
                    }
                }

                $this->set_msg(TRUE);
                $this->session->set('verify_code', $this->ticket->code)
                              ->set('movie_title', $this->show->movie->title)
                              ->set('start_date', $this->show->start_date)
                              ->set('places_amount',(is_array($_POST['place'])) ? sizeof($_POST['place']) : 1)
                              ->set('price', $this->ticket->price)
                              ->set('places', $places);
                $this->request->redirect(Route::get('reservation')->uri(array('action' => 'checkout')));

            } else {
                $this->template->content->errors = $post->errors('reservation');
                $this->set_msg(FALSE);
            }
        }
    }

    public function action_checkout() {
        $this->template->content = View::factory('checkout')
                                   ->bind('info_table', $info_table);
        $info_table = View::factory('reservation_info')
                      ->set('price', $this->session->get('price'))
                      ->set('verify_code', $this->session->get('verify_code'))
                      ->set('start_date', $this->session->get('start_date'))
                      ->set('movie_title', $this->session->get('movie_title'))
                      ->set('places_amount', $this->session->get('places_amount'))
                      ->set('places', $this->session->get('places'));
    }

    public function check_place_amount(Validate $array, $field) {
        if ($_POST['type'] == 1) {
            if (is_array($_POST['place'])) {
                if (sizeof($_POST['place']) < 2) {
                    $array->error($field, 'place_amount');
                }
            } 
        }
    }

    private function add_reservation($place_id, $arr_obj) {
        $place = ORM::factory('place', (int) $place_id);
        if ( ! $this->ticket->has('places', $place)) {
            $this->ticket->add('places', $place);
        }
        $arr_obj->append($place);
    }

}
?>

