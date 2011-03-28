<?php defined('SYSPATH') or die('No direct script access');
return array(
        'title' => array(
            'not_empty' => 'Tytuł filmu nie może być pusty',
            'min_length' => 'Minimalna długość tytułu filmu to :param1 znaków.',
            'max_length' => 'Maksymalna długość tytułu filmu to :param1 znaków.',
            'unique' => 'Istnieje już tytuł filmu o takiej nazwie. Musisz podać inną.',
        ),
        'premiere' => array(
            'date' => 'Nieprawidłowy format daty. Przykład formatu to DD-MM-RRRR.',
        ),
        'duration' => array(
            'not_empty' => 'Musisz podać czas trwanie filmu.',
            'range' => 'Minimalna długość filmu to :param1, maksymalna to :param2',
        ),
        'min_age' => array(
            'not_empty' => 'Musisz podać ograniczenie wiekowe.',
            'range' => 'Minimalny wiek ograniczenia wiekowego to :param1 lat, maksymalny :param2 lat.',
        ),
        'description' => array(
            'not_empty' => 'Musisz podać opis filmu.',
            'min_length' => 'Minimalna długość opisu filmu to :param1 znaków.',
            'max_length' => 'Maksymalna długość opisy filmu to :param1 znaków.',
        ),
        'unique' => array(
            'Istnieje już film o takim tytule. Musisz podać inny tytuł.',
        ),
        'poster' => array(
            'Upload::valid' => 'Przesłanie pliku nie powiodło się.',
            'Upload::type' => 'Nieprawidło rozszerzenie przesłanego pliku. Dopuszczalne rozszerzenia to :param1',
            'Upload::size' => 'Rozmiar przesłanego pliku jest zbyt duży. Maksymalny rozmiar to: param1.'
        )
);
?>
