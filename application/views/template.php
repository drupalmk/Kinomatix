<?php echo '<?xml version="1.0" encoding="utf-8"?'.">\n"; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<?php define('REQ', '<span style="color: red">*</span>') ?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pl" lang="pl">
  <head>
      <title><?php echo HTML::chars($page_title) ?></title>
      <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
      <?php
        foreach($styles as $style) {
            echo HTML::style($style);
        }
        echo HTML::script('media/js/jquery.min.js');
        echo HTML::script('media/js/jquery.ui.datepicker-pl.js');
        echo HTML::script('media/js/table.js');
        foreach($scripts as $script) {
            echo HTML::script($script);
        }
      ?>
  </head>
  <body>
      <div id="wrapper">
          <div id="header">
              <h1><a href="<?php echo url::base() ?>"><span>Kinomatix</span></a></h1>
              <ul id="top-menu">
                  <li><?php echo HTML::link('default', array('action' => 'home'), 'Aktualności', array('class' => 'first-item')) ?></li>
                  <li><?php echo HTML::link('shows', array('action' => 'upcoming'), 'Repertuar') ?></li>
                  <li><?php echo HTML::link('default', array('action' => 'opinions'), 'Napisali o nas') ?></li>
                  <?php if ($is_admin OR $is_user) { ?>
                  <li><?php echo HTML::link('user', array('action' => 'logout'), 'Wyloguj') ?></li>
                  <?php } else  {
                       if (! $is_admin) {
                           echo '<li>'.HTML::link('user', array('action' => 'register'), 'Rejestracja').'</li>';
                       }     
                   ?>
                  <li><?php echo HTML::link('user', array('action' => 'login'), 'Zaloguj') ?></li>
                  <?php } ?>
              </ul>
          </div>
          <div id="content-wrapper">
              <div id="page-content">
                    <?php
                        echo $message;
                        echo $content
                    ?>
              </div>
              <div id="sidebar">
                  <?php if ($is_admin): ?>
                  <div class="box">
                      <h2>Panel administratora</h2>
                      <div class="box-content">
                          <ul>
                              <li><?php echo HTML::link('shows', array('controller' => 'shows', 'action' => 'add'), 'Dodaj seans'); ?></li>
                              <li><?php echo HTML::link('admin', array('controller' => 'movies', 'action' => 'add'), 'Dodaj film'); ?></li>
                              <li><?php echo HTML::link('admin', array('controller' => 'cinemas', 'action' => 'add'), 'Dodaj kino'); ?></li>
                              <li><?php echo HTML::link('genres', array('action' => 'add', 'controller' => 'genres'), 'Gatunki filmowe'); ?></li>
                              <li><?php echo HTML::link('makers', array('action' => 'add', 'controller' => 'makers'), 'Twórcy filmowi'); ?></li>
                              <li><?php echo HTML::link('admin', array('controller' => 'news', 'action' => 'add'), 'Dodaj news'); ?></li>
                              <li><?php echo HTML::link('verifier', array('action' => 'ticket'), 'Weryfikacja rezerwacji'); ?></li>
                              <li><?php echo HTML::anchor(Route::get('admin')->uri(array('controller' => 'logout')), 'Wyloguj') ?></li>
                          </ul>
                      </div>
                  </div>
                  <?php endif ?>
                  <!--<div class="box">
                      <h2>Seans</h2>
                      <div class="box-content">
                          <?php echo FORM::open(Route::get('shows')->uri(array('action' => 'find')), array('method' => 'get')) ?>
                          <ul>
                              <li><?php echo FORM::input('search', NULL, array('class' => 'search-fld', 'id' => 'shows-fld'))?></li>
                              <li><?php echo FORM::submit(NULL, 'Wyszukaj seans', array('style' => 'padding: 2px 4px')) ?></li>
                          </ul>
                          <?php echo FORM::close() ?>
                      </div>
                  </div>-->
                  <div class="box">
                      <h2>Wyszukaj film</h2>
                      <div class="box-content">
                          <?php echo FORM::open(Route::get('movies')->uri(array('action' => 'find')), array('method' => 'get')) ?>
                          <ul>
                              <li><?php echo FORM::input('search', NULL, array('class' => 'search-fld', 'id' => 'movie-fld'))?></li>
                              <li><?php echo FORM::submit(NULL, 'Szukaj', array('style' => 'padding: 2px 4px')) ?></li>
                          </ul>
                          <?php echo FORM::close() ?>
                      </div>
                  </div>
                  <div class="box">
                      <h2>Najwyżej oceniane</h2>
                      <div class="box-content">
                          <ol>
                              <?php foreach($movies as $movie): ?>
                              <li><?php echo HTML::anchor(Route::get('movies')->uri(array('action' => 'id', 'id' => $movie->id)), $movie->title, array('style' => 'color: #F36; font-weight: bold; text-align: left')) ?></li>
                              <?php endforeach; ?>
                          </ol>
                      </div>
                  </div>
                  <div class="box">
                      <h2>Seanse w naszych kinach</h2>
                      <div class="box-content">
                          <ul>
                              <?php foreach(ORM::factory('cinema')->get_cinemas() as $cinema): ?>
                              <li>
                                  <span class="cinema-name"><?php echo HTML::chars($cinema->name)?></span>
                                  <?php $shows = $cinema->shows->find_all();
                                        if ($shows->count()) {
                                           echo '<ul>';
                                           foreach($shows as $show) {
                                              echo '<li>'.HTML::anchor(Route::get('reservation')->uri(array('action' => 'show', 'id' => $show->id)), $show->movie->title.' ('.DATE::locale_date("m.d, G:i", $show->start_date).')', array('style' => 'color: #F36; font-weight: bold; text-align: left')).'</li>';
                                           }
                                           echo '</ul>';
                                        }
                                  ?>
                              </li>
                              <?php endforeach ?>
                          </ul>
                      </div>
                  </div>
              </div>
          </div>
      </div>
      <div id="footer">
            <p>Kinomatix</p>
      </div>
    <script type="text/javascript">
            var ajaxCache = {};

            $('#movie-fld').each(function() {
                var currInput = $(this);
                currInput.autocomplete({
                    source: function(request, response) {
                        var cachedTerm = (request.term).toLowerCase();
                        if (ajaxCache[cachedTerm] != undefined) {
                            response($.map(ajaxCache[cachedTerm], function(item) {
                                    return {
                                        label: item.title,
                                        value: item.title
                                    }
                                }
                            ));
                        } else {
                            $.ajax({
                                url: "<?php echo url::base() ?>movies/find",
                                data: {
                                    search: request.term
                                },
                                dataType: "json",
                                success: function(data) {
                                        ajaxCache[cachedTerm] = data;
                                        response($.map(data, function(item){
                                            return {
                                                label: item.title,
                                                value: item.title
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

               $.datepicker.setDefaults($.datepicker.regional['pl']);
               $('#shows-fld').datepicker({ dateFormat: 'dd.mm.yy' });

               $('.cinema-name').toggle(function() {
                       $(this).next().slideDown();
               }, function() {
                   $(this).next().slideUp();
               }).next().hide();

    </script>
  </body>
</html>
