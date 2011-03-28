<?php defined('SYSPATH') or die('No direct script accesss allowed') ?>
<table id="checkout" cellspacing="0">
    <tr id="verify-code">
        <th scope="row">Kod weryfikacyjny</th>
        <td><?php echo isset($_POST['code']) ? $_POST['code'] : $verify_code ?></td>
    </tr>
    <tr>
        <th scope="row">Tytuł filmu</th>
        <td><?php echo $movie_title ?></td>
    </tr>
    <tr>
        <th scope="row">Czas rozpoczęcia</th>
        <td><?php echo DATE::locale_date( "l j F, Y, H:i", $start_date ) ?></td>
    </tr>
    <tr>
        <th scope="row">Liczba miejsc</th>
        <td><?php echo $places_amount ?></td>
    </tr>
    <tr>
        <th scope="col" colspan="2" style="text-align: center">Lista miejsc</th>
    </tr>
    <?php $i = 1; foreach($places as $place): ?>
    <tr>
        <th>Numer miejsca <?php echo $i++ ?></th>
        <td><?php echo strtoupper($place->code); ?></td>
    </tr>
    <?php endforeach ?>
    <tr>
        <th scope="row" style="border-bottom: none">W sumie do zapłaty</th>
        <td style="border-bottom: none"><?php echo $price ?> zł</td>
    </tr>
</table>