<?php defined('SYSPATH') or die('No direct script access allowed') ?>
<div class="box">
  <h2>Edytor</h2>
  <div class="box-content">
    <?php
        $action = Request::instance()->action;
        $params = array('action' => $action);
        if ($action == 'edit') {
            $params['id'] = $cinema->id;
        }
        echo FORM::open(Route::get('cinemas')->uri($params));
    ?>
    <fieldset>
          <legend>Kino</legend>
          <?php FORM::show_errors($errors) ?>
          <div>
              <label for="name">Nazwa</label><br />
              <input type="text" id="name" name="name" value="<?php echo $cinema->name ?>"/>
          </div>
          <div>
              <label for="address">Adres</label><br />
              <input type="text" id="address" name="address" value="<?php echo $cinema->address ?>"/>
          </div>
          <div>
              <label for="city">Miasto</label><br />
              <input type="text" id="city" name="city" value="<?php echo $cinema->city ?>"/>
          </div>
          <div>
              <label for="provinces">Województwo</label>
              <?php
                foreach($provinces as $p) {
                    $provinces_opts[$p->id] = $p->name;
                }
                echo FORM::select('province_id', $provinces_opts, $cinema->province, array('id' => 'provinces'));
              ?>
          </div>
          <div>
              <label for="phone">Telefon</label><br />
              <input type="text" id="phone" name="phone" value="<?php echo $cinema->phone ?>"/>
          </div>
          <div class="button-wrapper" style="width: 50%">
              <input type="submit" name="submit" value="Zapisz"/>
          </div>
      </fieldset>
      <?php echo FORM::close() ?>
  </div>
</div>
<?php
        echo View::factory('cinemas')->set('cinemas', $cinemas)->render();

?>
<script type="text/javascript">
$(document).ready(function() {
    $('#name').counter({maxLength : 100});
    $('#address').counter({maxLength : 100});
    $('#city').counter({maxLength : 100});
})
</script>
