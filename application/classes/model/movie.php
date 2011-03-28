<?php defined('SYSPATH') or die('No direct script allowed');
/*
 * Model reprezentujący filmy w systemie.
 */
class Model_Movie extends Model_Kinomatix {
  /*
   * Deklaracja relacji z bazy danych
   */
  /*
   * Określenie relacji wiele-do-wielu
   * Kod: 'makers' => array('through' => 'moviesmakers')
   * oznacza, że model Movie, czyli model filmu ma wielu twórców,
   * a tablicą łączącą jest 'moviesmakers'
   */
  protected $_has_many = array('makers' => array('through' => 'moviesmakers'), 'shows' => array());
  /*
   * Określenie relacji jeden-do-wielu.
   * Poniższa deklaracja oznacza, że dany film należy do jednego gatunku ('genre')
   * i do jednego oceny ('rate') ponieważ jego oceny przechowywana są w jednym
   * wierszu tabeli z ocenami
   */
  protected $_belongs_to = array('genre' => array(), 'rate' => array());
  /*
   * Koniec deklaracji relacji z bazy danych
   */

/**
 * Deklaracja filtrów, którym mają zostać poddane dane, przed zapisem do bazy.
 * 'trim' oznacza, że zostaną usunięte wszystkie białe znaki z początku i końca
 * wyrazu.
 */
  protected $_filters = array(
        'title' => array(
            'trim' => NULL,
        ),
        'duration' => array(
            'trim' => NULL,
        ),
        'description' => array(
            'trim' => NULL,
        )
  );
/**
 * Koniec deklaracji filtrów
 */
/**
 * Deklaracja reguł, które muszą spełniać przekazane do modelu dane przed
 * ich zapisem do bazy.
 * Opis wybranych reguł:
 *      'not_empty' - pole nie może być puste,
 *      'min_empty' - określa minimalną długość słowa,
 *      'max_empty' - określa maksymalną długość słowa,
 *      'range' - określa przedział w jakim może znajdować się przekazana liczba,
 */
  protected $_rules = array(
        'title' => array(
            'not_empty' => NULL,
            'min_length' => array(2),
            'max_length' => array(100),
        ),
        'duration' => array(
            'not_empty' => NULL,
            'range' => array(1, 255),
        ),
        'min_age' => array(
            'not_empty' => NULL,
        ),
        'description' => array(
            'not_empty' => NULL,
            'min_length' => array(20),
            'max_length' => array(4000),
        ),
       'poster' => array(
                 'Upload::valid' => NULL,
                 'Upload::type' => array('Upload::type' => array('jpg', 'png', 'gif')),
                 'Upload::size' => array('1M'),
        ),
   );
/**
 * Koniec deklaracji reguł
 */
/**
 * Deklaracja wywołań zwrotnych, którym mają podlegać określone dane.
 * Poniższa deklaracja określa, że przekazany tytuł filmy, zostanie sprawdzony
 * pod wzlędem unikalności
 */
   protected $_callbacks = array(
        'title' => array('unique'),
   );
/*
 * Pole przechowuje model oceny powiązanej z filmem
 */
   private $movie_rate;

/*
 * Poniższa metoda sprawdza poprawność danych przekazanych, po przez wywołanie
 * parent::check() oraz przypisuje danemu filmu ścieżkę z plikiem plakatu jeśli
 * został wgrany na serwer
 */
   public function check() {
       $is_valid = parent::check();
       if ($is_valid) {
           $this->poster = ! empty($this->poster['name']) ? $this->poster['name'] : $this->poster;
       }
       return $is_valid;
   }

/*
 * Metoda zapisująca jeden rekord w bazie
 */
   public function save() {
       /*
        * Jeśli plik plakatu filmu został wgrany na serwer, zostanie zapisany
        * pod określoną lokalizacją: 'media/img/posters_big'
        */
       if (! empty($this->poster) AND ! is_array($this->poster)) {
           Upload::save($_FILES['poster'], $this->poster,'media/img/posters_big');
       } else {
           $this->poster = NULL;
       }
       /*
        *Jeśli dany rekord jest tworzone, zostanie zapisany czas jego utworzenia.
        * W przeciwnym wypadku zostanie zapisana data jego ostatniej modyfikacji
        */
       if (empty($this->created)) {
           $this->created = time();
       } else {
           $this->last_modified = time();
       }
       parent::save();
   }
/*
 * Poniższa funkcja służy do dodania twórców do filmu. Twórcą może być aktor,
 * reżyser lub scenarzysta.
 * $makers - tablica z obiektami filmowców
 */
   public function add_makers($makers) {
       $makers_ids = array(); // tablica przechowująca identyfikatory dostarczonych filmowców

       foreach($makers as $maker) {
           $makers_ids[] = $maker->id;
           /*
            * Jeśli dany film nie posiada jeszcze relacji z przekazanym filmowcem
            * taka relacja jest tworzona.
            */
           if (! $this->has('makers', $maker)) {
               $this->add('makers', $maker);
           }
       }
       /*
        * Pobranie poprzednio zapisanych twórców danego filmu.
        */
       $curr_makers = $this->makers->find_all();
       foreach($curr_makers as $maker) {
           /*
            * Jeśli identyfikator poprzednio połączonego z filmem twórcy
            * nie znajduje się w aktualnie przekazanej tablicy filmówców,
            * relacja między takim filmowcem a filmem zostanie usunięta
            */
           if (! in_array($maker->id, $makers_ids)) {
               $this->remove('makers', $maker);
           }
       }
   }
/**
 * Funkcja zwracająca tablicę przechowującą wszyskich twórców danego filmu
 */
   public function get_makers_array() {
       $makers = $this->makers->find_all();
       $result = array();
       foreach ($makers as $maker) {
           $result[] = $maker;
       }
       return $result;
   }
/*
 * Funkcja zwraca liczbę filmowców powiązanych z filmem
 */
   public function get_makers_count() {
       return $this->makers->count_all();
   }
/*
 * Funckja zwraca nazwę gatunku filmu
 */
   public function get_genre() {
       return $this->genre->name;
   }
/*
 * Funkcja zwraca reżysera lub reżyserów filmu
 */
   public function get_directors() {
       return $this->get_makers_by_type(1);
   }
/*
 * Funkcja zwraca scenarzystę lub scenarzystów filmu
 */
   public function get_screenwriters() {
       return $this->get_makers_by_type(3);
   }
/*
 * Funkcja zwraca aktorów występujących w danych filmie
 */
   public function get_actors() {
       return $this->get_makers_by_type(2);
   }
/*
 * Funkcja zwraca twórców filmu na podstawie przekazanego identyfikatora typu
 */
   public function get_makers_by_type($type) {
       return $this->makers->where('type', '=', $type)->find_all();
   }
/*
 * Funkcja wyszukająca filmy na podstawie tytułu
 */
   public function find_by_title($title) {
       if (empty($title)) {
           return new ArrayObject();
       }
       $title = '%'.$title.'%';
       return $this->where('title', 'LIKE', $title )->find_all();
   }
/*
 * Funkcja dodająca ocenę dla filmu
 */
   public function add_rate($new_rate) {
        $this->get_rate_model()->add_rate($new_rate);
   }
/*
 * Funkcja zwracająca średnią ocenę filmu
 */
   public function get_avg_rate() {
       return $this->get_rate_model()->get_avg_rate();
   }
/*
 * Funkcja zwracająca sumę ocen filmu
 */
   public function get_rates_count() {
       return $this->get_rate_model()->get_rates_count();
   }
/*
 * Funkcja zwracają najlepsze filmy na podstawie ocen użytkowników
 */
   public function get_top_movies() {
       $rates = ORM::factory('rate')->get_top_rates();
       $movies = new ArrayObject();
       foreach($rates as $rate) {
            $movies->append(ORM::factory('movie', $rate->movie_id));
       }
       return $movies;
   }
/*
 * Funkcja zwracająca model oceny powiązanej z filmem.
 */
   private function get_rate_model() {
       if (! isset($this->movie_rate)) {
           $this->movie_rate = new Model_Rate(NULL, $this->id);
       }
       return $this->movie_rate;
   }
/*
 * Stała przechowująca rozszerzenie pliku, z którym zostanie zapisany plakat filmu.
 */
   CONST POSTER_EXT = '.png';
}
?>
