<?php defined('SYSPATH') or die('No direct script access') ?>
<div class="box text">
      <h2>Aktualności</h2>
      <?php
        if ($is_admin) {
           echo HTML::anchor(Route::get('admin')->uri(array('controller' => 'news', 'action' => 'add')),
                HTML::image('media/css/img/add_icon.png', array('title' => 'Dodaj news', 'alt' => 'Dodaj news')),
                array('class' => 'admin-action add'));
        } 
      ?>
      <?php foreach($news as $n): ?>
      <div class="box-content">
          <h3><?php echo HTML::chars($n->title) ?></h3>
          <?php echo DATE::print_date($n->created) ?>
          <p>
          <?php echo HTML::chars($n->content) ?>
          </p>
      </div>
      <?php if ($is_admin) {
           echo View::factory('admin/actions')
                ->set('controller', 'news')
                ->set('id', $n->id)
                ->render();
            }
      ?>
      <?php endforeach ?>
</div>
