<?php defined('SYSPATH') or die('No direct script access allowed') ?>
<div class="box">
  <h2>Edytor</h2>
  <div class="box-content">
    <?php
        $action = Request::instance()->action;
        $params = array('action' => $action);
        if ($action == 'edit') {
            $params['id'] = $genre->id;
        }
        echo FORM::open(Route::get('genres')->uri($params));
    ?>
    <fieldset>
          <legend>Gatunek filmowy</legend>
          <?php FORM::show_errors($errors) ?>
          <div>
              <label for="name">Nazwa</label><br />
              <input type="text" id="name" name="name" value="<?php echo $genre->name ?>"/>
          </div>
          <div class="button-wrapper" style="width: 50%">
              <input type="submit" name="submit" value="Zapisz"/>
          </div>
      </fieldset>
      <?php echo FORM::close() ?>
  </div>
</div>
<div class="box">
    <h2>Gatunki</h2>
    <div class="box-content">
        <table cellspacing="0" class="items">
            <caption>Lista gatunków filmowych</caption>
            <thead>
                <tr>
                    <th scope="col" class="name">Nazwa gatunku</th>
                    <th scope="col">Utworzony</th>
                    <th scope="col">Zmodyfikowany</th>
                    <th scope="col">Akcje</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $format = 'm.d.y H:i:s';
                foreach($genres as $genre) :?>
                <tr>
                    <td class="name"><?php echo HTML::chars($genre->name) ?></td>
                    <td><?php echo DATE::locale_date($format, $genre->created) ?></td>
                    <td><?php echo ! empty($genre->last_modified) ? DATE::locale_date($format, $genre->last_modified) : ''?></td>
                    <td><?php echo View::factory('admin/actions')
                                        ->set('controller', 'genres')
                                        ->set('id', $genre->id);
                        ?>
                    </td>
                </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>
</div>
<script type="text/javascript">
$(document).ready(function() {
    $('#name').counter({maxLength : 100});
})
</script>
