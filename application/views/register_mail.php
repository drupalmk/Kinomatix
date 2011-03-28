Cześć <?php echo $username ?>


Dziękujemy za rejestrację w Kinomatix. Po zalogowaniu będą mogli Państwo rezerwować miejsca na wybrane seansy oraz wystawić opinię o kinię.

Proszę potwierdzić swoją rejestrację klikając poniższy link:
<?php echo URL::site(Route::get('user/confirm')->uri(array('id' => $id, 'code' => $code)), TRUE)?>


Serdeczne Pozdrowienia
Kinomatix