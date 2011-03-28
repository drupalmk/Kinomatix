<?php defined('SYSPATH') or die('No direct script access');

    return array(
        'username' => array(
            'not_empty' => 'Nazwa użytkownika nie może być pusta.',
            'min_length' => 'Minimalna długość nazwy użytkownika to 3 znaki.',
            'max_length' => 'Maksymalna długość nazwy użytkownika to :param1 znaków.',
            'regex' => 'Niepoprawna nazwa użytkownika.',
            'invalid' => 'Niepoprawna nazwa użytkownika, złe hasło lub konto nie zostało aktywowane.',
            'username_available' => 'Podana nazwa użytkownika jest już zajęta.',
        ),
        'password' => array(
            'not_empty' => 'Hasło nie może być puste.',
            'min_length' => 'Minimalna długość hasła to 3 znaki.',
            'max_length' => 'Maksymalna długość hasła to: param1 znaków.',
        ),
        'password_confirm' => array(
            'matches' => 'Hasła nie pokrywają się.',
        ),
        'email' => array(
            'not_empty' => 'Musisz podać adres e-mail',
            'min_length' => 'Minimalna długość adresu e-mail to :param1 znaków',
            'max_length' => 'Maksymalna długość adresu e-mail to :param1 znaków',
            'email' => 'Niepoprawny adres e-mail.'
        ),
    );
?>
