<?php defined('SYSPATH') or die('No direct access allowed');

return array(
    'login' => array(
        'fail' => array(
            'index' => 'Przekazano nie prawidłowe dane.'
        ),
        'success' => array(
            'index' => 'Zalogowano z powodzeniem.',
        ),
    ),
    'user' => array(
        'fail' => array(
            'register' => 'Rejestracja nie powiodła się.',
            'confirm' => 'Aktywacja konta nie powiodła się lub konto jest już aktywowane.',
        ),
        'success' => array(
            'register' => 'Zarejestrowano z powodzeniem, proszę sprawdź swoją pocztę.',
            'confirm' => 'Konto aktywowane z powodzeniem, nastąpiło automatyczne logowanie.',
        )
    ),
    'news' => array(
        'fail' => array(
            'add' => "Dodanie news'a nie powiodło się.",
            'edit' => "Edytowanie news'a nie powiodło się.",
            'delete' => "Usunięcie news'a nie powiodło się."
        ),
        'success' => array(
            'add' => "News został dodany z powodzeniem.",
            'edit' => "News został edytowany z powodzeniem.",
            'delete' => "News został usunięty z powodzeniem."
        )
    ),
    'opinions' => array(
        'fail' => array(
            'add' => "Dodanie opinii nie powiodło się.",
            'edit' => "Edycja opinii nie powiodła się.",
            'delete' => "Usunięcie nie opinii powiodło się."
        ),
        'success' => array(
            'add' => "Opinia dodana z powodzeniem.",
            'edit' => "Opinia edytowana z powodzeniem.",
            'delete' => "Opinia została usunięta z powodzeniem."
        )
    ),
    'makers' => array(
        'success' => array(
            'add' => 'Dodanie filmowca powiodło się.',
        ),
        'fail' => array(
            'add' => 'Dodanie filmowca nie powiodło się.'
        )
    ),
    'movies' => array(
        'fail' => array(
            'add' => "Dodanie filmu nie powiodło się.",
            'edit' => "Edycja filmu nie powiodła się.",
            'delete' => "Usunięcie filmu nie powiodło się.",
            'rate' => 'Nie możesz oceniać tego samego filmu więcej niż jeden raz.'
        ),
        'success' => array(
            'add' => "Film dodany z powodzeniem.",
            'edit' => "Film edytowany z powodzeniem.",
            'delete' => "Film został usunięty z powodzeniem.",
            'rate' => 'Twoja ocena została dodana z powodzeniem.'
        )
    ),
    'genres' => array(
        'fail' => array(
            'add' => "Dodanie gatunku nie powiodło się.",
            'edit' => "Edycja gatunku nie powiodła się.",
            'delete' => "Usunięcie gatunku nie powiodło się."
        ),
        'success' => array(
            'add' => "Gatunek dodany z powodzeniem.",
            'edit' => "Gatunek edytowany z powodzeniem.",
            'delete' => "Gatunek został usunięty z powodzeniem."
        )
    ),
    'shows' => array(
        'fail' => array(
            'add' => "Dodanie seansu nie powiodło się.",
            'edit' => "Edycja seansu nie powiodła się.",
            'delete' => "Usunięcie seansu nie powiodło się."
        ),
        'success' => array(
            'add' => "Seans dodany z powodzeniem.",
            'edit' => "Seans edytowany z powodzeniem.",
            'delete' => "Seans został usunięty z powodzeniem."
        )
    ),
    'cinemas' => array(
        'fail' => array(
            'add' => "Dodanie kina nie powiodło się.",
            'edit' => "Edycja kina nie powiodła się.",
            'delete' => "Usunięcie kina nie powiodło się."
        ),
        'success' => array(
            'add' => "Kino dodane z powodzeniem.",
            'edit' => "Kino edytowane z powodzeniem.",
            'delete' => "Kino usunięte z powodzeniem."
        )
    ),
    'reservation' => array(
        'fail' => array(
            'show' => 'Nie udało się przeprowadzić rezerwacji.',
        ),
        'success' => array(
            'show' => 'Rezerwacja dodana z powodzeniem.',
        ),
    )

);

?>
