<nav>
  <ul class="menu" aria-label="Main Menu">
    <?php foreach( $app->menu as $link => $title ): ?>
    <li><a href="<?=$link?>"><?=$title?></a></li>
    <?php endforeach; ?>
  </ul>
  <script src="js/menu.js" deferred></script>
</nav>