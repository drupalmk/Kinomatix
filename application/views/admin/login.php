<?php defined('SYSPATH') or die('No direct script access') ?>
<div class="box">
  <h2>Administracja</h2>
  <div class="box-content">
      <?php echo form::open(Route::get('admin')->uri()) ?>
          <fieldset>
              <legend>Logowanie administratora</legend>
              <?php form::show_errors($errors) ?>
              <div>
                  <?php echo form::label('username', 'Nazwa użytkownika') ?><br />
                  <?php echo form::input('username', $post['username'], array('id' => 'username')) ?>
              </div>
              <div>
                  <?php echo form::label('password', 'Hasło') ?><br />
                  <?php echo form::password('password', NULL, array('id' => 'password')) ?>
              </div>
              <div class="button-wrapper" style="width: 50%">
                  <input type="submit" name="submit" value="Zaloguj"/>
              </div>
          </fieldset>
      <?php echo form::close() ?>
  </div>
</div>
