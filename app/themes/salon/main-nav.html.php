<nav>
  <ul class="menu" aria-label="Main Menu">
    <?php foreach( $view->menu as $link => $title ): ?>
    <li><a href="<?=($link==$app->homePage)?'':$link?>"><?=$title?></a></li>
    <?php endforeach; ?>
  </ul>
  <script src="js/menu.js" deferred></script>
</nav>