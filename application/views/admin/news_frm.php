<?php defined('SYSPATH') or die('No direct script access allowed') ?>
<div class="box">
  <h2>Edytor</h2>
  <div class="box-content">
    <?php
        $action = Request::instance()->action;
        $params = array('controller' => 'news', 'action' => $action);
        if ($action == 'edit') {
            $params['id'] = $news->id;
        }
        echo FORM::open(Route::get('admin')->uri($params));
    ?>
    <fieldset>
          <legend>Edytor news'a</legend>
          <?php FORM::show_errors($errors) ?>
          <?php
                echo FORM::hidden('user_id', Session::instance()->get('authorized_id'));
                if ($action == 'edit') {
                    echo DATE::print_date($news->created, 'Utworzony:');
                    if (! empty($news->last_modified)) {
                        echo DATE::print_date($news->last_modified, 'Zmodyfikowany:');
                    }
                }
          ?>
          <div>
              <label for="title">Tytuł</label><br />
              <input type="text" id="title" name="title" value="<?php echo $news->title?>"/>
          </div>
          <div>
              <label for="content">Treść</label><br />
              <textarea id="content" name="content" cols="10" rows="10"><?php echo $news->content ?></textarea>
          </div>
          <div class="button-wrapper">
              <input type="submit" name="submit" value="Zapisz"/>
          </div>
      </fieldset>
      <?php echo FORM::close() ?>
  </div>
</div>
<script type="text/javascript">
$(document).ready(function() {
    $('#title').counter({maxLength : 100});
    $('#content').counter({maxLength : 4000});
})
</script>
