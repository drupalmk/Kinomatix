<?php defined('SYSPATH') or die('No direct script access');
return array(
        'name' => array(
            'not_empty' => 'Proszę podać swoje imię.',
            'min_length' => 'Minimalna długość imienia to :param1 znaków',
            'max_length' => 'Maksymalna długość imienia to :param1 znaków.',
        ),
        'content' => array(
            'min_length' => 'Twoja opinia musi składać się z conajmniej :param1 znaków.',
            'max_length' => 'Maksymalna długość Twojej opinii to :param1 znaków.',
            'not_empty' => 'Proszę wpisać swoją opinią o naszym kinie.',
        ),
        'www' => array(
            'validate::url' => 'To nie jest akceptowany adres WWW. Przykład: http://www.strona.pl',
        )
)
?>
