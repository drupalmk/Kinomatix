<?php defined('SYSPATH') or die('No direct script access');
return array(
        'title' => array(
            'not_empty' => 'Tytuł news\'a nie może być pusty',
            'min_length' => 'Minimalna długość tytułu news\'a to :param1 znaków.',
            'max_length' => 'Maksymalna długość tytułu news\'a to :param1 znaków.',
            'unique' => 'Istnieje już tytuł news\'a o takiej nazwie. Musisz podać inną.',
        ),
        'content' => array(
            'min_length' => 'Minimalna długość news\'a to :param1 znaków.',
            'max_length' => 'Maksymalna długość news\'a to :param1 znaków.',
            'not_empty' => 'Treść news\'a nie może być pusta.',
        )
)
?>