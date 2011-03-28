<?php defined('SYSPATH') or die('No direct script access allowed') ?>
<div class="box">
  <h2>Edytor filmu</h2>
  <div class="box-content">
    <?php
        $action = Request::instance()->action;
        $params = array('controller' => 'movies', 'action' => $action);
        if ($action == 'edit') {
            $params['id'] = $movie->id;
        }
        echo FORM::open(Route::get('admin')->uri($params), array('enctype' => "multipart/form-data" ));
    ?>
    <?php FORM::show_errors($errors) ?>
    <fieldset>
          <legend>Film</legend>
          <?php
                if ($action == 'edit') {
                    echo DATE::print_date($movie->created, 'Utworzony:');
                    if (! empty($movie->last_modified)) {
                        echo DATE::print_date($movie->last_modified, 'Zmodyfikowany:');
                    }
                }
                echo REQ.' - elementy wymagane.';
                if (! empty($movie->id)) {
                    echo FORM::hidden('movie_id', $movie->id);
                }
          ?>
          <div>
              <?php echo FORM::label('title', 'Tytuł'.REQ) ?><br />
              <input id="title" type="text" name="title" value="<?php echo FORM::value($movie, 'title') ?>" style="width: 99.5%"/>
          </div>
          <?php
              foreach($genres as $genre) {
                $genres_opts[$genre->id] = $genre->name;
              }
              $ages[1] = 'b/o';
              for ($i = 5; $i < 22; $i++) {
                 $ages[$i] = $i;
              }

          ?>
          <table class="inputs">
               <tr>
                  <td><?php echo FORM::label('duration', 'Czas trwania (w minutach)'.REQ) ?></td>
                  <td><input id="duration" type="text" name="duration" value="<?php echo FORM::value($movie, 'duration') ?>" maxlength="3" size="3" style="width: 35px"</td>
              </tr>
              <tr>
                  <td><?php echo FORM::label('genres', 'Wybierz gatunek'.REQ);  ?></td>
                  <td>
                  <?php
                      echo FORM::select('genre_id', $genres_opts, FORM::value($movie, 'genre_id'), array('id', 'genres'));
                      echo HTML::link('genres', array('action' => 'add', 'controller' => 'genres'),
                      HTML::image('media/css/img/add_icon.png', array('title' => 'Dodaj gatunek', 'alt' => 'Dodaj gatunek'))
                      ,array('style' => 'margin: 5px 0 0 5px'));
                  ?>
                  </td>
              </tr>
              <tr>
                  <td><?php echo FORM::label('min_age', 'Ograniczenie wiekowe'.REQ) ?></td>
                  <td><?php echo FORM::select('min_age', $ages, FORM::value($movie, 'min_age'), array('id' => 'min_age')); ?></td>
              </tr>
          </table>
          <div>
              <?php echo FORM::label('description', 'Opis'.REQ) ?><br />
              <textarea id="description" name="description" cols="10" rows="10"><?php echo FORM::value($movie, 'description') ?></textarea>
          </div>
          <div>
              <label for="poster">Plakat filmu</label>
              <input id="poster" type="file" name="poster"/>
          </div>
      </fieldset>
      <fieldset>
          <legend>Twórcy filmu</legend>
              <?php  print_makers_fields($action, $makers_count, $movie, $makers_errors) ?>
              <div style="margin: 15px 0">
                  <label for="makers-count-switcher" style="float: left; margin: 8px 5px 0 0">Zmień liczbę twórców</label>
                  <?php
                    for ($i = 1; $i < 11; $i++) {
                        $options[$i] = $i;
                    }
                    echo FORM::select('makers-count', $options, $makers_count, array('style' => 'float: left;', 'id' => 'makers-count-switcher'));
                    echo FORM::submit('makers-count-change', 'Odśwież', array('style' => 'float: left; margin-left: 5px'));
                   ?>
              </div>
      </fieldset>
      <div class="button-wrapper">
          <input type="submit" name="submit" value="Zapisz"/>
      </div>
      <?php echo FORM::close() ?>
  </div>
</div>
<?php
    function print_makers_fields($action, $counter, $movie, $errors) {
        $makers = $movie->get_makers_array();
        fire::log($makers, 'makers');
        for ($i = 0; $i < $counter; $i++) {
            print_maker_field($i, isset($makers[$i]) ? $makers[$i] : NULL, $errors);
        }
    }

    function print_maker_field($i, $maker, $errors) {
       $options = array(1 => 'Reżyser', 2 => 'Aktor', 3 => 'Scenarzysta');
       echo '<div>';
       echo FORM::label('maker'.$i, 'Twórca '.($i + 1).' ').'<br />';
       echo FORM::input('makers['.$i.'][name]', get_maker_value($i, 'name', isset($maker) ? $maker : NULL), array('id' => 'maker'.$i));
       echo FORM::select('makers['.$i.'][type]', $options, get_maker_value($i, 'type', isset($maker) ? $maker : NULL, $default = 2), array('style' => 'margin-left: 5px'));
       if (isset($maker) AND ! empty($maker->id)) {
            echo FORM::hidden('makers['.$i.'][id]', $maker->id);
       }
       print_maker_error($i, $errors);
       echo '</div>';
    }

    function get_maker_value($idx, $key, $maker = NULL, $default = NULL) {
        if (isset($maker)) {
            return $maker->$key;
        } else if (isset($_POST['makers'])) {
            if (isset($_POST['makers'][$idx])) {
                return $_POST['makers'][$idx][$key];
            }
        } else return $default;
    }

    function print_maker_error($index, $errors) {
        if ($_POST) {
            if (isset($errors)) {
                if (isset($errors[$index])) {
                    echo '<div class="error under-field">'.$errors[$index]['name'].'</div>';
                }
            }
        }
    }
?>
<script type="text/javascript">
$(document).ready(function() {
    $('#title').counter({maxLength : 255});
    $('#description').counter({maxLength : 4000});
    $('input[id^=maker]').each(function() {
        $(this).counter({maxLength: 100});
    });

    var ajaxCache = {};

    $('input[id^=maker]').each(function() {
        var currInput = $(this);
        currInput.autocomplete({
            source: function(request, response) {
                var makerType = currInput.next().val();
                var cachedTerm = (request.term + ' ' + makerType).toLowerCase();
                if (ajaxCache[cachedTerm] != undefined) {
                    response($.map(ajaxCache[cachedTerm], function(item) {
                            return {
                                label: item.name,
                                value: item.name
                            }
                        }
                    ));
                } else {
                    $.ajax({
                        url: "<?php echo url::base() ?>makers/find",
                        data: {
                            type: makerType,
                            search: request.term
                        },
                        dataType: "json",
                        success: function(data) {
                                ajaxCache[cachedTerm] = data;
                                response($.map(data, function(item){
                                    return {
                                        label: item.name,
                                        value: item.name
                                    }
                                }))
                        }
                    });
                }
            },
            minLength: 3,
            select: function(event, ui) {
            this.close;
            },
            open: function() {
                $(this).removeClass("ui-corner-all").addClass("ui-cornet-top");
            },
            close: function() {
                $(this).removeClass("ui-corner-top").addClass("ui-corent-all");
            }
        })
    })
  
})
</script>