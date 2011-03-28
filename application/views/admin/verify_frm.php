<?php defined('SYSPATH') or die('No direct script access allowed') ?>
<div class="box">
    <h2>Weryfikacja</h2>
    <div class="box-content">
        <h3>Sprawdź kod rezerwacji</h3>
        <?php
            if (! empty($verify_msg)) {
                echo '<div class="info">'.$verify_msg.'</div>';
            }
            echo FORM::show_errors($errors);
            echo FORM::open();
            echo '<div style="width: 70%">';
            echo FORM::label('code', 'Wprowadź kod');
            echo '<br />';
            echo FORM::input('code', $verify_code, array('id' => 'code', 'style' => 'width: 65%;'));
            echo FORM::submit('submit', 'Sprawdź kod');
            echo '</div>';
            echo FORM::close();
            echo $summary;
        ?>
    </div>
</div>
