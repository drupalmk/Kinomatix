<?php defined('SYSPATH') or die('No direct script access');

    return array(
//        'name' => array(
//            'min_length' => 'Minimalna dopuszczalna długość nazwy to: param1.',
//            'max_length' => 'Maksymalna dopuszczalna długość nazwy to:param1.',
//        ),
        'start_date' => array(
            'not_empty' => 'Musisz podać datę i godzinę rozpoczęcia seansu.',
            'date_in_future' => 'Musisz podać datę i godzinę seansu w przyszłości, większą o co najmniej :param1 godzin od aktualnej godziny.',
            'start_date_free' => 'W tym dniu i czasie trwa już seans w naszym kinie. Ustaw inną datę rozpoczęcia seansu.',
        ),
        'end_date' => array(
            'end_date_free' => 'Czas trwanie seansu koliduje z rozpoczęciem innego seansu. Pamiętaj, że do czasu trwania każdego seansu, dodawany jest czas :param1 minut.'
        )
    );
?>
