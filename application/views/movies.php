<?php defined('SYSPATH') or die('No direct script access'); ?>
<!--
 HTML - początek kontenera o klasie 'box' przechowującego listing filmów
-->
<div class="box">
    <h2>Lista znalezionych filmów</h2>
    <div class="box-content">
        <?php
        /**
         * Jeśli aktualnie zalogowanym użytkownikiem jest administrator, wyświetla link służący
         * do dodania nowego filmu
         */
        if ($is_admin) {
           echo HTML::anchor(Route::get('admin')->uri(array('controller' => 'movies', 'action' => 'add')),
                HTML::image('media/css/img/add_icon.png', array('title' => 'Dodaj film', 'alt' => 'Dodaj film')),
                array('class' => 'admin-action add'));
        }
        /*
         * Jeśli nie ma dostępnych żadnych filmów, wyświetla odpowiedni komunikat
         */
        if (! $movies->count()) {
            echo '<div class=info style="clear: both">Niczego nie znaleziono.</div>';
        } else {
        ?>
        <!--
        Początek właściwej listy filmów
        -->
        <ul id="movies-titles-list">
        <?php foreach($movies as $movie): ?>
            <!--
                Wyświetla element listy w raz linkiem do widoku wybranego filmu
            -->
            <li><?php echo HTML::anchor('#movie'.$movie->id, $movie->title) ?></li>
        <?php endforeach ?>
        </ul>
        <?php
            foreach($movies as $movie) :
                /**
                 * Jeśli aktualnie zalogowanym użytkownikiem jest admin
                 * wyświetla menu narzędziowe do edycji danego aktualnie przekazanego
                 * w pętli filmu
                 */
                if ($is_admin) {
                   echo View::factory('admin/actions')
                        ->set('controller', 'movies')
                        ->set('id', $movie->id)
                        ->render();
                 }
        ?>
            <!--
                Wyświetlenie tytułu filmu wraz z plakatem
            -->
            <dl>
                <dt id="movie<?php echo $movie->id ?>"><?php echo $movie->title ?></dt>
                <dd class="description">
                    <h3>Treść</h3>
                    <p>
                        <?php
                            echo HTML::image('media/img/posters_big/'.$movie->poster, array('alt' => 'plakat'));
                            echo $movie->description;
                        ?>
                    </p>
                </dd>
                <!--
                    Wyświetlenie listy reżyserów
                -->
                <dd>
                    <h3>Reżyseria</h3>
                    <p>
                    <?php
                        foreach($movie->get_directors() as $d) {
                            echo $d->name.'<br />';
                        }
                    ?>
                    </p>
                </dd>
                <!-- Wyświetlenie listy scenarzystów -->
                <dd>
                    <h3>Scenariusz</h3>
                    <p>
                    <?php
                        foreach($movie->get_screenwriters() as $sw) {
                            echo $sw->name.'<br />';
                        }
                    ?>
                    </p>
                </dd>
                <!-- Wyświetlenie listy aktorów -->
                <dd>
                    <h3>Obsada</h3>
                    <p>
                    <?php
                        foreach($movie->get_actors() as $actor) {
                            echo $actor->name.'<br />';
                        }
                    ?>
                    </p>
                </dd>
                <!-- Wyświetlenie gatunku filmu, czasu trwania i ograniczenia wiekowe -->
                <dd>
                    <h3>Właściwości</h3>
                    <p>
                        Gatunek: <?php echo $movie->get_genre() ?><br />
                        Czas trwania: <?php echo $movie->duration ?> min<br />
                        Ograniczenie wiekowe: <?php echo $movie->min_age == 1 ? 'b/o' : $movie->min_age ?><br />
                    </p>
                </dd>
                <!-- Wyświetlenie formularza z aktulną oceną filmu, wraz z możliwością dodania nowej oceny -->
                <dd class="rate">
                    <h3>Oceń film</h3>
                    <div class="stars">
                        <p>
                            <?php
                                 $avg = $movie->get_avg_rate() ? $movie->get_avg_rate() : 'Brak.';
                                 $rates_count = $movie->get_rates_count() ? $movie->get_rates_count() : 'Nie oddano żadnych głosów.';
                            ?>
                            Średnia ocena: <span class="current-movie-rate"><?php echo $avg ?></span><br />
                            Ogółem ocen: <span class="current-movie-rates-count"><?php echo $rates_count ?></span>
                        </p>
                        <?php
                            echo FORM::open('movies/rate');
                            echo FORM::label('rate1', '1');
                            echo FORM::radio('rate', '1', FALSE, array('id' => 'rate1'));
                            echo FORM::label('rate2', '2');
                            echo FORM::radio('rate', '2', FALSE, array('id' => 'rate2'));
                            echo FORM::label('rate3', '3');
                            echo FORM::radio('rate', '3', FALSE, array('id' => 'rate3'));
                            echo FORM::label('rate4', '4');
                            echo FORM::radio('rate', '4', FALSE, array('id' => 'rate4'));
                            echo FORM::label('rate5', '5');
                            echo FORM::radio('rate', '5', TRUE, array('id' => 'rate5'));
                            echo FORM::submit('submit', 'Głosuj');
                            echo FORM::hidden('movie_id', $movie->id, array('class' => 'movie'));
                            echo FORM::hidden('avg_rate', $movie->get_avg_rate(), array('class' => 'avg-rate'));
                            echo FORM::close();
                        ?>
                    </div>
                </dd>
            </dl>
        <?php
            endforeach;
        }
        ?>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        $('.stars').each(function() {
            var stars = $(this),
            currentValue = parseInt(stars.find('.avg-rate').val()),
            additionalData = { "movie_id" :stars.find('.movie').val() };
            stars.rater('<?php url::base() ?>rate/', {style:'basic', maxvalue:5, curvalue: currentValue, addData : additionalData });
        });
        $('.stars > form').hide();

    });
</script>