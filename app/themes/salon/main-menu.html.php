<ul class="menu" aria-label="Main Menu">
  <?php foreach ( $view->menu as $link => $item ): ?>
  <?php if ( is_array( $item ) ): ?>
  <li class="has-submenu"><?=$link?>
    <ul class="submenu">
    <?php foreach ( $item as $sublink => $subitem ): ?>
      <li><a href="<?=$sublink?>"><?=$subitem?></a></li>
    <?php endforeach; ?>
    </ul>
  </li>
  <?php else: ?>
  <li><a href="<?=($link==$app->homePage)?'':$link?>"><?=$item?></a></li>
  <?php endif; ?>
  <?php endforeach; ?>
</ul>
<script src="js/menu.js" deferred></script>