<?php defined('SYSPATH') or die('No direct script access allowed') ?>
<div class="box">
  <h2><?php if (isset($form_title)) echo $form_title; else echo 'Edytor' ?></h2>
  <div class="box-content">
    <?php
        $params = array('controller' => 'opinions', 'action' => $action);
        if ($action == 'edit') {
            $params['id'] = $opinion->id;
        }
        echo FORM::open(Route::get('opinions')->uri($params));
    ?>
    <fieldset>
          <legend><?php if (isset($legend)) echo $legend; else echo 'Edytor opinii' ?></legend>
          <?php FORM::show_errors($errors) ?>
          <?php
                if ($action == 'edit') {
                    echo DATE::print_date($opinion->created, 'Utworzona:');
                    if (! empty($opinion->last_modified)) {
                        echo DATE::print_date($opinion->last_modified, 'Zmodyfikowana:');
                    }
                }
          echo REQ.' - elementy wymagane.'
          ?>
          <div>
              <?php echo FORM::label('content', 'Twoja opinia o nas'.REQ) ?><br />
              <textarea id="content" name="content" cols="10" rows="10"><?php echo $opinion->content ?></textarea>
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
           $('#name').counter({maxLength : 50});
           $('#content').counter({maxLength : 1000});
           $('#www').counter({maxLength : 100});
       })
</script>
