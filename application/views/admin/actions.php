<?php defined('SYSPATH') or die('No direct script access') ?>
<span class="actions">
    <?php echo HTML::anchor(Route::get('admin')->uri(array('controller' => $controller, 'action' => 'edit', 'id' => $id)),
            HTML::image('media/css/img/edit_icon.png', array('alt' => 'Edytuj', 'title' => 'Edytuj')), array('class' => 'admin-action edit')) ?>
    <?php echo HTML::anchor(Route::get('admin')->uri(array('controller' => $controller, 'action' => 'delete', 'id' => $id)),
            HTML::image('media/css/img/delete_icon.png', array('alt' => 'Usuń', 'title' => 'Usuń')), array('class' => 'admin-action delete'))  ?>
</span>
