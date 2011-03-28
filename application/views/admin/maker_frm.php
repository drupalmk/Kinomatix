<?php defined('SYSPATH') or die('No direct script access allowed') ?>
<div class="box">
  <h2>Edytor</h2>
  <div class="box-content">
    <?php
        $action = Request::instance()->action;
        $params = array('controller' => 'makers', 'action' => $action);
        echo FORM::open(Route::get('admin')->uri($params));
    ?>
    <fieldset>
          <legend>Edytor filmowca</legend>
          <?php FORM::show_errors($errors) ?>
          <?php
                echo FORM::hidden('user_id', Session::instance()->get('authorized_id'));
          ?>
          <div>
              <label for="name">Imię i nazwisko</label><br />
              <input type="text" id="name" name="name" value="<?php echo $maker->name ?>"/>
              <?php
                echo FORM::select('type', array(1 => 'Reżyser', 2 => 'Aktor', 3 => 'Scenarzysta' ), $maker->type, array('id' => 'type'));
              ?>
          </div>
          <div class="button-wrapper" style="width: 68%">
              <input type="submit" name="submit" value="Zapisz"/>
          </div>
      </fieldset>
      <?php echo FORM::close() ?>
  </div>
</div>
<div class="box">
    <h2>Twórcy</h2>
    <div class="box-content">
        <table cellspacing="0" class="items">
            <caption>Lista zapisanych filmowców</caption>
            <thead>
                <tr>
                    <th scope="col" class="name">Imię i nazwisko</th>
                    <th scope="col">Utworzony</th>
                    <th scope="col">Zmodyfikowany</th>
                    <th scope="col">Typ</th>
                    <th scope="col">Akcje</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $format = 'd.m.y H:i:s';
                foreach($makers as $maker) :?>
                <tr>
                    <td class="name"><?php echo HTML::chars($maker->name) ?></td>
                    <td><?php echo DATE::locale_date($format, $maker->created) ?></td>
                    <td><?php echo ! empty($maker->last_modified) ? DATE::locale_date($format, $maker->last_modified) : ''?></td>
                    <td><?php print_type($maker->type) ?></td>
                    <td><?php echo View::factory('admin/actions')
                                        ->set('controller', 'genres')
                                        ->set('id', $maker->id);
                        ?>
                    </td>
                </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>
</div>
<?php
    function print_type($type) {
        $type = (int) $type;
        switch($type) {
            case 1: echo 'Reżyser';
                    break;
            case 2: echo 'Aktor';
                    break;
            case 3: echo 'Scenarzysta';
                    break;
            default:
                echo '';
        }
    }
?>
<script type="text/javascript">
$(document).ready(function() {
    $('#name').counter({maxLength : 100});
})
</script>
