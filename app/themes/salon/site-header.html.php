<header class="site-header">
  <nav class="flex wrap">
    <a id="top" class="brand flex" href="" nofollow="">
      <img src="img/logo-00.jpg" alt="Cafe &amp; Salon Allure Logo">
      <h1><?=$app->title?></h1> 
    </a>
    <div class="main-menu-wrapper flex reverse">
      <input id="mobile-menu-control" type="checkbox" class="hidden">
      <?php include $view->getThemeFile( 'main-menu' ); ?>
      <label class="hamburger-icon" for="mobile-menu-control">
        <i></i><i></i><i></i>
      </label>
    </div>
  </nav>
</header>