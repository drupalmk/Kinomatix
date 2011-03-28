<?php defined('SYSPATH') or die('No direct script access') ?>
<div class="box text">
      <h2>Napisali o nas</h2>
      <?php
        $curr_user = Auth::instance()->get_user();
        $has_opinion = FALSE;
      ?>
      <?php foreach($opinions as $o): ?>
      <div class="box-content">
          <h3 style="font-size: 18px"><?php echo HTML::chars($o->user->username) ?></h3>
          <?php echo DATE::print_date($o->created) ?>
          <p>
          <?php echo HTML::chars($o->content) ?>
          </p>
          <?php
           if ($curr_user) {
                 if ($o->user->id == $curr_user->id) {
                     $has_opinion = TRUE;
                     echo html::link('opinions', array('action' => 'edit', 'id' => $o->id),
                             'Edytuj', array('class' => 'link'));
                 }
           }
          ?>
      </div>
      <?php
        if ($is_admin) {
           echo View::factory('admin/actions')
                ->set('controller', 'opinions')
                ->set('id', $o->id)
                ->render();
            }
      ?>
      <?php endforeach ?>
</div>
<?php 
    if (! $is_admin && $is_user && ! $has_opinion) {
        echo $form;
    }
?>

