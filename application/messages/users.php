<?php defined('SYSPATH') or die('No direct script access');
return array(
        'username' => array(
            'regex' => 'Nazwa użytkownika może składać się tylko z liter. Minimalna długość to 4, a maksymalna to 24 znaków.',
            'not_empty' => 'Nazwa użytkownika nie może być pusta.',
            'min_length' => 'Minimalna długość nazwy użytkownika to 3 znaki',
            'invalid' => 'Niepoprawna nazwa użytkownika lub hasło.',
        ),
        'password' => array(
            'min_length' => 'Minimalna długość hasła to 3 znaki',
            'not_empty' => 'Hasło nie może być puste.',
        )
)
?>