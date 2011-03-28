<?php defined('SYSPATH') or die('No direct script access');
return array(
        'name' => array(
            'not_empty' => 'Musisz podać nazwę kina.',
            'min_length' => 'Minimalna długość nazwy kina to :param1 znaków.',
            'max_length' => 'Maksymalna długość nazwy kina to :param1 znaków.',
        ),
        'address' => array(
            'not_empty' => 'Musisz podać adres kina.',
            'min_length' => 'Minimalna długość adresu kina to :param1 znaków.',
            'max_length' => 'Maksymalna długość adresu kina to :param1 znaków.',
        ),
        'city' => array(
            'not_empty' => 'Musisz podać miasto w którym znajduję się kino.',
            'min_length' => 'Minimalna długość nazwy miasta to :param1 znaków.',
            'max_length' => 'Maksymalna długość nazwy miasta to :param1 znaków.',
        ),
        'phone' => array(
            'not_empty' => 'Musisz podać numer telefonu kina.',
            'digit' => 'Numer telefonu kina musi być liczbą',
        ),
)
?>
