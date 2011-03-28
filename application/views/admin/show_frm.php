<?php defined('SYSPATH') or die('No direct script access allowed') ?>
<div class="box">
  <h2>Edytor</h2>
  <div class="box-content">
    <?php
        $action = Request::instance()->action;
        $params = array('action' => $action);
        if ($action == 'edit') {
            $params['id'] = $show->id;
        }
        echo FORM::open(Route::get('shows')->uri($params));
    ?>
    <fieldset>
          <legend>Seans</legend>
          <?php
                if ($action == 'edit') {
                    echo DATE::print_date($show->created, 'Utworzony:');
                    if (! empty($news->last_modified)) {
                        echo DATE::print_date($show->last_modified, 'Zmodyfikowany:');
                    }
                }
                FORM::show_errors($errors);
                echo REQ.' - elementy wymagane.';
          ?>
          <div>
              <label for="movie">Wybierz film<?php echo REQ ?></label>
              <?php
                foreach ($movies as $movie) {
                    $options[$movie->id] = HTML::chars($movie->title);
                }
                echo FORM::select('movie_id', $options, $show->movie_id, array('id' => 'movie'));
              ?>
          </div>
          <div>
              <label for="cinemas">Wybierz kino<?php echo REQ ?></label>
         <?php
                foreach($cinemas as $c) {
                    $cinemas_opts[$c->id] = $c->name;
                }
                echo FORM::select('cinema_id', $cinemas_opts, $show->cinema, array('id' => 'cinemas'));
          ?>
          </div>
          <h2>Wybierz dzień seansu<?php echo REQ ?></h2>
          <div id="day-picker">
              <label for="day">Dzień</label>
              <?php
                   echo FORM::select('start_day[]', DATE::days_as_numbers(),
                        $show->start_date ? (int) date('j', $show->start_date) : (int) date('j', time() + 60 * 60 * 24), array('id' => 'day'))
              ?>
              <label for="month">Miesiąc</label>
              <?php
                    echo FORM::select('start_day[]', DATE::month_names_singular(),
                        $show->start_date ? (int) date('n', $show->start_date) : (int) date('n'), array('id' => 'month'))
              ?>
              <label for="year">Rok</label>
              <?php
                    echo FORM::select('start_day[]', DATE::years(date('Y'), date('Y') + 10),
                        $show->start_date ? (int) date('Y', $show->start_date) : (int) date('Y'), array('id' => 'year'));
              ?>
          </div>
          <h2>Ustaw godzinę rozpoczęcia seansu<?php echo REQ ?></h2>
          <div id="start-time-picker" style="margin-left: 10px">
              <?php
                echo FORM::select('start_time[]', DATE::hours(1, TRUE),
                        $show->start_date ? (int) date('G', $show->start_date) : 15);
                echo ':';
                echo FORM::select('start_time[]', DATE::minutes(),
                        $show->start_date ? (int) date('i', $show->start_date) : NULL);
              ?>
          </div>
          <div class="button-wrapper">
              <input type="submit" name="submit" value="Zapisz seans"/>
          </div>
      </fieldset>
      <?php echo FORM::close() ?>
  </div>
</div>
<?php

    echo View::factory('shows')->set('shows', $shows)->render();
?>
<script type="text/javascript">
$(document).ready(function() {
    $('#name').counter({maxLength : 100});
        var datePickerBox = $('#day-picker'),
            field = $('<input/>').attr({
                                    'type' : 'text',
                                    'name' : 'start_day',
                                    'id'   : 'start_day'
                                 }).val($('#day').val() + '.' + $('#month').val() + '.' + $('#year').val());
           datePickerBox.children().hide();
           datePickerBox.append(field);
           $.datepicker.setDefaults($.datepicker.regional['pl']);
           field.datepicker({ dateFormat: 'dd.mm.yy' });
})
</script>
