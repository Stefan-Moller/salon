<ul class="menu" aria-label="Main Menu">
  <?php foreach( $view->menu as $link => $item ): ?>
  <?php $isHome = $link==$app->homePage; ?>
  <?php $itemClass =  $isHome ? 'menu-item home' : 'menu-item'; ?>
  <?php $itemLink =  $isHome ? '' : $link; ?>
  <?php if( is_array( $item ) ): ?>
  <li class="menu-item has-submenu">
    <a href="<?=$link?>"><?=$item[0]?></a>
    <ul class="submenu">
    <?php foreach( $item[1] as $sublink => $subitem ): ?>
      <li><a href="<?=$sublink?>"><?=$subitem?></a></li>
    <?php endforeach; ?>
    </ul>
  </li>
  <?php else: ?>
  <li class="<?=$itemClass?>"><a href="<?=$itemLink?>"><?=$item?></a></li>
  <?php endif; ?>
  <?php endforeach; ?>
</ul>