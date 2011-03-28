<?php defined('SYSPATH') or die('No direct script access') ?>
<div class="box">
  <h2>Rejestracja</h2>
  <div class="box-content">
      <?php echo form::open(Route::get('user')->uri(array('action' => 'register'))) ?>
          <fieldset>
              <legend>Rejestracja użytkownika</legend>
              <?php form::show_errors($errors) ?>
              <div>
                  <?php echo form::label('username', 'Nazwa użytkownika') ?><br />
                  <?php echo form::input('username', $post['username'], array('id' => 'username')) ?>
              </div>
              <div>
                  <?php echo form::label('password', 'Hasło') ?><br />
                  <?php echo form::password('password', NULL, array('id' => 'password')) ?>
              </div>
              <div>
                  <?php echo form::label('password-confirm', 'Powtórzone hasło') ?><br />
                  <?php echo form::password('password_confirm', NULL, array('id' => 'password-confirm')) ?>
              </div>
             <div>
                  <?php echo form::label('email', 'E-mail') ?><br />
                  <?php echo form::input('email', $post['email'], array('id' => 'email')) ?>
              </div>
              <div class="button-wrapper" style="width: 50%">
                  <input type="submit" name="submit" value="Zarejestruj"/>
              </div>
          </fieldset>
      <?php echo form::close() ?>
  </div>
</div>