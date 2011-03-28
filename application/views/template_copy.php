<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
  <head>
      <title><?php echo HTML::chars($page_title) ?></title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <?php 
        foreach($styles as $style) {
            echo html::style($style);
        }
        foreach($scripts as $script) {
            echo html::script($script);
        }
    ?>
  </head>
  <body>
      <div id="wrapper">
          <div id="header">
              <h1><span><?php echo HTML::chars($page_title) ?></span></h1>
              <ul id="top-menu">
                  <li><a href="" class="active first-item">Aktualności</a></li>
                  <li><a href="">Zapowiedzi</a></li>
                  <li><a href="">Repertuar</a></li>
                  <li><a href="">Recenzje</a></li>
                  <li><a href="">Kontakt</a></li>
                  <li><a href="">Opinie</a></li>
              </ul>
          </div>
          <div id="content-wrapper">
              <div id="content">
                  <div class="box">
                      <h2>Aktualności</h2>
                      <div class="box-content">
                          <h3>Jakiś tam news</h3>
                          <span>Poniedziałek, 26 Maja 2010, 13:40</span>
                          <p>
                           Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed sit amet augue id massa gravida ullamcorper a in nibh. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Donec consequat, sem sit amet posuere volutpat, orci enim eleifend eros, vitae pretium risus dui quis arcu. Pellentesque nec dictum metus. Phasellus semper iaculis risus non condimentum. Aenean elementum interdum quam ullamcorper ullamcorper. Donec mattis diam sed lectus aliquam auctor. Donec metus nibh, ornare ut molestie et, rhoncus id metus. In mi lacus, convallis in pretium vel, hendrerit sit amet nibh. Curabitur vitae ligula erat, vel fermentum leo. Cras porttitor dui sit amet felis commodo tempor. Praesent nec lacus vel lorem fringilla blandit. Donec erat massa, commodo vitae iaculis eget, imperdiet at lacus. Integer a purus vitae enim fringilla laoreet nec ac lectus. Curabitur fringilla velit a ante placerat tempus. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Vestibulum ac vehicula massa.
                          </p>
                      </div>
                      <div class="box-content">
                          <h3>Jakiś tam news</h3>
                          <span>Poniedziałek, 26 Maja 2010, 13:40</span>
                          <p>
                           Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed sit amet augue id massa gravida ullamcorper a in nibh. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Donec consequat, sem sit amet posuere volutpat, orci enim eleifend eros, vitae pretium risus dui quis arcu. Pellentesque nec dictum metus. Phasellus semper iaculis risus non condimentum. Aenean elementum interdum quam ullamcorper ullamcorper. Donec mattis diam sed lectus aliquam auctor. Donec metus nibh, ornare ut molestie et, rhoncus id metus. In mi lacus, convallis in pretium vel, hendrerit sit amet nibh. Curabitur vitae ligula erat, vel fermentum leo. Cras porttitor dui sit amet felis commodo tempor. Praesent nec lacus vel lorem fringilla blandit. Donec erat massa, commodo vitae iaculis eget, imperdiet at lacus. Integer a purus vitae enim fringilla laoreet nec ac lectus. Curabitur fringilla velit a ante placerat tempus. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Vestibulum ac vehicula massa.
                          </p>
                          <p>
                           Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed sit amet augue id massa gravida ullamcorper a in nibh. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Donec consequat, sem sit amet posuere volutpat, orci enim eleifend eros, vitae pretium risus dui quis arcu. Pellentesque nec dictum metus. Phasellus semper iaculis risus non condimentum. Aenean elementum interdum quam ullamcorper ullamcorper. Donec mattis diam sed lectus aliquam auctor. Donec metus nibh, ornare ut molestie et, rhoncus id metus. In mi lacus, convallis in pretium vel, hendrerit sit amet nibh. Curabitur vitae ligula erat, vel fermentum leo. Cras porttitor dui sit amet felis commodo tempor. Praesent nec lacus vel lorem fringilla blandit. Donec erat massa, commodo vitae iaculis eget, imperdiet at lacus. Integer a purus vitae enim fringilla laoreet nec ac lectus. Curabitur fringilla velit a ante placerat tempus. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Vestibulum ac vehicula massa.
                          </p>
                      </div>
                  </div>
                  <div class="box">
                      <h2>Przykłady komunikatów</h2>
                      <div class="box-content">
                        <div class="message info">Informacja</div>
                        <div class="message success">Sukces</div>
                        <div class="message warning">Ostrzeżenie</div>
                        <div class="message error">Błąd</div>
                      </div>
                  </div>
                  <div class="box">
                      <h2>Przykład formularza</h2>
                      <div class="box-content">
                          <form action="" method="post">
                              <fieldset>
                                  <legend>Dane osobowe</legend>
                                  <div class="validation">
                                      <ul>
                                          <li><label for="name">Podanie imienia jest wymagane</label></li>
                                          <li><label for="surname">Podanie nazwiska jest wymagane</label></li>
                                      </ul>
                                  </div>
                                  <div>
                                      <label for="name">Imię</label><br />
                                      <input type="text" id="name" name="name"/>
                                  </div>
                                  <div>
                                      <label for="surname">Nazwisko</label><br />
                                      <input type="text" id="surname" name="surname"/>
                                  </div>
                                  <div class="button-wrapper">
                                      <input type="submit" name="submit" value="Zapisz"/>
                                  </div>
                              </fieldset>
                          </form>
                      </div>
                  </div>
              </div>
              <div id="sidebar">
                  <div class="box">
                      <h2>TOP 10</h2>
                      <div class="box-content">
                          <ol>
                              <li><a href="">Jakiś tam film</a></li>
                              <li><a href="">Jakiś tam film</a></li>
                              <li><a href="">Jakiś tam film</a></li>
                              <li><a href="">Jakiś tam film</a></li>
                              <li><a href="">Jakiś tam film</a></li>
                              <li><a href="">Jakiś tam film</a></li>
                              <li><a href="">Jakiś tam film</a></li>
                              <li><a href="">Jakiś tam film</a></li>
                              <li><a href="">Jakiś tam film</a></li>
                              <li><a href="">Jakiś tam film</a></li>
                          </ol>
                      </div>
                  </div>
                  <div class="box">
                      <h2>Zapowiedzi</h2>
                      <div class="box-content">
                          <ul>
                              <li><a href="">Jakiś tam film</a></li>
                              <li><a href="">Jakiś tam film</a></li>
                              <li><a href="">Jakiś tam film</a></li>
                              <li><a href="">Jakiś tam film</a></li>
                              <li><a href="">Jakiś tam film</a></li>
                              <li><a href="">Jakiś tam film</a></li>
                              <li><a href="">Jakiś tam film</a></li>
                              <li><a href="">Jakiś tam film</a></li>
                              <li><a href="">Jakiś tam film</a></li>
                              <li><a href="">Jakiś tam film</a></li>
                          </ul>
                      </div>
                  </div>
              </div>
          </div>
      </div>
      <div id="footer">
            <p>Kinomatix</p>
      </div>
	<?php if (Kohana::$environment !== Kohana::PRODUCTION) { ?>
		<div id="kohana-profiler">
			<?php echo View::factory('profiler/stats') ?>
			<p>$_POST = <?php echo Kohana::debug($_POST) ?></p><hr />
			<p>$_SESSION = <?php echo Kohana::debug(Session::instance()->as_array()) ?></p><hr />
			<p>$_COOKIE = <?php echo Kohana::debug($_COOKIE) ?></p>
		</div><!-- #kohana-profiler -->
	<?php } ?>
  </body>
</html>
