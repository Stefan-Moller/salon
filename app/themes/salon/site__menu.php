<div class="menu__wrapper flex reverse">
  <input id="menu-toggle" class="menu__toggle" type="checkbox">
  <label class="menu__toggleicon" for="menu-toggle"><i></i><i></i><i></i></label>
  <ul class="menu menu__mobile" aria-label="Main Menu">
  <?php foreach( $view->menus['main']->items as $item ): ?>
    <?php $isHome = $item->href == $app->homePage; ?>
    <?php $itemHref =  $isHome ? '' : $item->href; ?>
    <?php if( $item->submenu ): ?>
    <li class="submenu__wrapper<?=$item->class?' '.$item->class:''?>">
      <a class="submenu__toggle" href="javascript:void(0)"><?=$item->icon?><span><?=$item->label?></span></a>
      <ul class="submenu" aria-label="<?=$item->label?> Submenu">
      <?php foreach( $item->submenu->items as $sub ): ?>
        <li<?=$sub->class?' class="'.$sub->class.'"':''?>><a href="<?=$sub->href?>"><?=$sub->icon?><span><?=$sub->label?></span></a></li>
      <?php endforeach; ?>
      </ul>
    </li>
    <?php else: ?>
    <li<?=$item->class?' class="'.$item->class.'"':''?>><a href="<?=$item->href?>"><?=$item->icon?><span><?=$item->label?></span></a></li>
    <?php endif; ?>
  <?php endforeach; ?>
  </ul>
</div>