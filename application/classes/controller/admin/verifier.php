<?php defined('SYSPATH') or die('No direct script access allowed');

class Controller_Admin_Verifier extends Controller_Admin_Admin {

    public function before() {
        parent::before();
        $this->template->content = new View('admin/verify_frm');
        $this->template->content->verify_msg = '';
        $this->template->content->verify_code = '';
        $this->template->content->summary = '';
    }

    public function action_ticket() {
        if ($_POST) {
            if (empty($_POST['code'])) {
                $this->template->content->errors = array('code', 'Musisz podać kod weryfikacyjny.');
                return;
            }
            $ticket = ORM::factory('ticket')->get_by_code($_POST['code']);
            $show = $ticket->show->find();
            $movie_title = $show->movie->find()->title;
            if ($ticket->loaded()) {
                $this->template->content->summary = View::factory('reservation_info')
                                                    ->set('verify_code', $ticket->code)
                                                    ->set('movie_title', $movie_title)
                                                    ->set('start_date', $show->start_date)
                                                    ->set('places_amount', $ticket->get_places_count())
                                                    ->set('price', $ticket->price)
                                                    ->set('verify_code', $ticket->code)
                                                    ->set('places', $ticket->get_places());
                $this->template->content->verify_msg = 'System znalazł rezerwację oznaczoną tym kodem.';

            } else {
                $this->template->content->verify_msg = 'Nie znaleziono żadnej rezerwacji powiązanej z tym kodem.';
            }
        }        
    }
}
?>
