<?php defined('SYSPATH') or die('No direct script access allowed');
/*
 * Kontroler odpowiedzialny za obsługę żądań dotyczących filmów w systemie.
 * Dziedziczy po kontrolerze, w którym znajdują się operacje i metody wspólne dla
 * wszystkich kontrolerów, np autoryzacja użytkownika.
 */
class Controller_Admin_Movies extends Controller_Admin_Admin {
    /*
     * pola przechowują model filmu
     */
    private $movie;

    /*
     * Funkcja automatycznie wykonywana przed każdą akcją.
     */
    public function before() {
        parent::before();
        //utworzenie instancji modelu
        $this->movie = ORM::factory('movie');
    }
    /*
     * Funkcja wyświetlająca film o określonym identyfikatorze
     */
    public function action_id($id) {
        /*
         * wyszukanie filmu o określonym identyfikatorze, odebranym z parametru
         * przekazanym w obiekcie żądania
         */
        $this->movie->find(Request::instance()->param('id'));
        /*
         * Utworzenie kolekcji przechowującą obiekt danego filmu.
         * Jest to kolekcja ponieważ widok, który wykorzystuje ta akcja obsługuje
         * całą kolekcę filmów, a nie pojedynczy film
         */
        $movies = new ArrayObject();
        /*
         * Dodanie filmu do kolekcji
         */
        $movies->append($this->movie);
        /**
         * Dodanie do głównego widoku z szablonem strony, widok wyświetlający
         * listing filmów. W tym przypadku będzie to pojedyczny film.
         */
        $this->template->content = View::factory('movies')
                                   ->set('movies', $movies);
        /**
         * Dodanie stylu i skryptu używanych przez aktualną stronę
         */
        $this->template->styles = array('media/css/rater.css');
        $this->template->scripts = array('media/js/jquery.rater.js');
    }
/**
 * Funkcja wyszukająca filmy po tytułach
 */
    public function action_find() {
        //Jeśli żądanie jest żądeniem Ajax'owym
        if ($this->is_ajax) {
            /*
             * Pobranie listy filmów na podstawie przekazanych kryteriów
             */
            $movies = $this->movie->find_by_title($_GET['search']);
            /**
             * Utworzenie tablicy przechowującej rezultat wyszukiwania, w tym
             * przypadku tytuły znalezionych filmów
             */
            $result = array();
            /**
             * Dodanie tytułów znalezionych filmów do tablicy
             */
            foreach ($movies as $movie) {
                $result[]['title'] = $movie->title;
            }
            /*
             * Wysłanie odpowiedzi w formacie JSON
             */
            echo json_encode($result);
        } else {
            /*
             * Jeśli żądanie jest zwykłem żądaniem, zostanie wyświetlona lista filmów
             * spełniających przekazane kryterium. Widok zostanie utworzony analogicznie jak w poprzedniej
             * funkcji
             */
            $this->template->content = View::factory('movies')
                                       ->set('movies', $this->movie->find_by_title($_GET['search']));
            $this->template->styles = array('media/css/rater.css');
            $this->template->scripts = array('media/js/jquery.rater.js');
        }
    }
/*
 * Funkcja dodający nowy film
 */
    public function action_add() {
        //przekazanie działanie do funkcji prywatnej odpowiedzialnej za obsługę
        //formularza z filmem.
        $this->process_frm();
    }
/*
 * Funkcja edytująca film o określonym identyfikatorz
 */
    public function action_edit($id) {
        $this->movie->find(Request::instance()->param('id'));
        $this->process_frm();
    }
/*
 * Funkcja usuwająca film o danym identyfikatorze
 */
    public function action_delete($id) {
        //usunięcie filmu na podstawie pobranego identyfikatora
        $this->movie->delete(Request::instance()->param('id'));
        //ustawienia komunikatu o powodzeniu operacji
        $this->set_msg(TRUE);
        //przekierowanie na stronę główną
        $this->request->redirect(Route::get('default')->uri());
    }
/*
 * Funkcja służąca do oceny danego filmu
 */
    public function action_rate() {
        //Jeśli żądanie jest żądaniem typu POST
        if ($_POST) {
            //Wyszukanie filmu na podstawie przekazanego w POST identyfikatora
            $this->movie->find((int) $_POST['movie_id']);
            //Dodanie oceny na podstawie oceny przekazanej w tablicy POST
            $this->movie->add_rate((int) $_POST['rating']);
            //Jeśli żądanie nie jest żądaniem Ajax'owym
            if (! $this->is_ajax) {
                //ustawienie komunikatu powodzenia operacji
                $this->set_msg(TRUE);
                //przekierowanie na poprzedni adres
                $this->request->redirect($this->session->get('PREV_URI'));
            } else {
                //Jeśli żądanie jest żądaniem Ajax'owym
                /*
                 * Utworzenie tablicy data, zawierającej aktualną średnią ocenę
                 * filmu i liczbę oddanych ocen na dany film
                 */
                $data['avg_rate'] = $this->movie->get_avg_rate();
                $data['rates_count'] = $this->movie->get_rates_count();
                /*
                 * Wysłanie tablicy w formacie JSON
                 */
                echo json_encode($data);
            }
        }
    }
/*
 *Funkcja obsługująca dodawanie i edytowanie filmu przez fomularz HTML
 */
    private function process_frm() {
        /**
         * Przekazanie referencji do obiektu filmu, błędów, liczby dodawanych w
         * formularzu twórców i listy gatunków filmowych do widoku z formularzem
         * filmu
         */
        $this->template->content = View::factory('admin/movie_frm')
                                   ->bind('movie', $this->movie)
                                   ->bind('errors', $errors)
                                   ->bind('makers_errors', $makers_errors)
                                   ->bind('makers_count', $makers_count)
                                   ->set('genres', ORM::factory('genre')->find_all());
        $this->template->scripts = array('media/js/jquery.counter.js');
        $this->template->styles = array('media/css/ui-lightness/jquery-ui.css');
        /**
         * Jeśli formularz jest wykorzystywany do dodania nowego filmy, ustawia
         * standardową liczbę twórców dodawanych dla danego filmu na 4
         */
        if ($this->request->action == 'add') {
            $makers_count = 4;
        } else {
            /**
             * W przypadku edycji filmu zostanie wyświetlonych tyle pól z twórcami,
             * ile posiada danych film
             */
            $makers_count = $this->movie->get_makers_count();
        }
        /**
         * Jeśli żądanie jest żądaniem POST
         */
        if ($_POST) {
            /*
             * Jeśli została przekazana zmiana liczby pól dodawanych twórców
             */
            if (isset($_POST['makers-count-change'])) {
                $makers_count = (int) $_POST['makers-count'];
            } else {
                if (isset($_POST['makers-count'])) {
                    $makers_count = (int) $_POST['makers-count'];
                }
                //flaga oznaczająca, że wszystkie dane przekazanych twórców są poprawne
                $are_makers_valid = TRUE;
                //tablica błędów dla poszczególnych twórców
                $makers_errors = array();
                //tablicy przechowujący obiekty twórców, które przeszły poprawnie sprawdzanie danych
                $valid_makers = array();
                //tablicy z przekazanymi danymi o twórcach
                $makers = $_POST['makers'];
                //pobrania wielkości tablic twórców
                $length = sizeof($makers);
                for($i = 0; $i < $length; $i++) {
                    //pobranie danych o aktualnie przekazanym do pętli twórcy
                    $values = $makers[$i];
                    //przechowanie imienia i nazwiska twórcy i oczyszczenie z białych znaków
                    $name = trim($values['name']);
                    //Jeśli pola nie jest puste
                    if (! empty($name)) {
                        //pobrania typu dodawanego twórcy
                        $type = $values['type'];
                        //utworzenie instancji modelu twórcy
                        $maker = ORM::factory('maker');
                        //Wybór funkcji pobierającej twórcę na podstawie imienia i nazwiska za pomocą
                        //przekazanego typu
                        switch ($type) {
                            case 1:
                               $func = 'get_director_by_name';
                               break;
                           case 2:
                               $func = 'get_actor_by_name';
                               break;
                           case 3:
                               $func = 'get_screenwriter_by_name';
                               break;
                        }
                        //wywołanie funkcji na obiekcie modelu, w raz przekazanym jej parametrem name
                        //reprezentującym imię i nazwisko twórcy
                        $maker = call_user_func(array($maker, $func), $name);
                        /*
                         * Wywołanie metody zapisującej danego twórcę jeśli sprawdzenie jego danych
                         * odniesie powodzenie, zwracającej true w przypadku powodzenia sprawdzanie
                         * i zapisu twórcy
                         */

                        if ($this->save_maker_if_valid($maker, $i, $makers_errors, $values)) {
                            //dodanie obiektu twórcy do tablicy z twórcami, których dane są poprawne
                            $valid_makers[] = $maker;
                        } else {
                            //ustawienie flagi walidacji twórców na fałsz, jeśli walidacja danych jakiegoś
                            //twórcy nie powiodła się
                            $are_makers_valid = FALSE;
                        }
                    } 
                }
                //zapisanie danych pobranych w żądaniu w obiekcie reprezentującym film
                $this->movie->values(array_merge($_POST, $_FILES));
                //Jeśli wszyszczy twórcy są poprawnie zapisani i dane przekazane o filmie
                if (($is_success = $this->movie->check() AND $are_makers_valid)) {
                    //zapisanie filmu
                    $this->movie->save();
                    //dodanie relacji między obiektami twórców a filmem
                    $this->movie->add_makers($valid_makers);
                    //ustawienie komunikatu powodzenia operacji
                    $this->set_msg(TRUE);
                    //przekierowanie na tą samą stronę
                    $this->request->redirect(Request::instance()->uri);
                } else {
                    //pobranie błędów
                    $errors = $this->movie->get_errors();
                    //ustawienie komunikatu o nie powodzenie operacji dodawania nowego filmu
                    $this->set_msg(FALSE);
                }
            }
        }
    }

    private function save_maker_if_valid($maker, $idx, & $errors, $values) {
        /*
         * Jeśli w przekazanych danych o danym twórcy występuję jego identyfikator
         * to znaczy, że taki twórca już istnieje w systemie, zostaną załadowane dane
         * na jego temat z tablicy
         */
        if (isset($values['id'])) {
            $maker->find($values['id']);
            unset($values['id']);
        }
        /*
         * Zapisanie przekazanych aktualnie danych w obiekcie twórcy
         */
        $maker->values($values);
        //Jeśli obiekt przejdzie walidację nastąpi zapisanie i zwrócenie true
        if ($maker->check()) {
            $maker->save();
            return TRUE;
        } else {
            //Jeśli nie w tablicy błędów pod numerem porządkowych oznaczającym zbiór pól formularza
            //dla danego twórcy zostaną zapisane błędy, które zaistniały podczas sprawdzanie poprawności
            //danych
            $errors[$idx] = $maker->get_errors();
            return FALSE;
        }
    }
}
?>
