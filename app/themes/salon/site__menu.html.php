<div class="menu__wrapper flex reverse">
  <input id="menu-toggle" class="menu__toggle" type="checkbox">
  <label class="menu__toggleicon" for="menu-toggle"><i></i><i></i><i></i></label>
  <ul class="menu menu__mobile" aria-label="Main Menu">
  <?php foreach( $view->menu as $link => $item ): ?>
    <?php $isObj = is_object( $item ); ?>
    <?php $isHome = $link==$app->homePage; ?>
    <?php $itemLink =  $isHome  ? '' : $link; ?>
    <?php $itemType  = $isObj ? $item->type : 'item'; ?>
    <?php $itemIcon  = $isObj ? $item->icon  ?? '' : ''; ?>
    <?php $itemClass = $isObj ? $item->class ?? '' : ''; ?>
    <?php $itemLabel = $isObj ? $item->label ?? '' : $item; ?>
    <?php if( $itemType == 'item' ): ?>
    <li<?=$itemClass?' class="'.$itemClass.'"':''?>><a href="<?=$itemLink?>"><?=$itemIcon?><span><?=$itemLabel?></span></a></li>
    <?php continue; endif; ?>
    <?php if( $itemType == 'submenu' ): ?>
    <li class="<?=$itemClass?:'submenu__wrapper'?>">
      <a class="submenu__toggle"><?=$itemIcon?><span><?=$itemLabel?></span></a>
      <ul class="submenu" aria-label="<?=$itemLabel?> Submenu">
        <?php foreach( $item->subitems as $sublink => $subitem ): ?>
        <?php $subObj  = is_object( $subitem ); ?>
        <?php $subLink =  $isHome  ? '' : $sublink; ?>
        <?php $subIcon  = $subObj ? $subitem->icon  ?? '' : ''; ?>
        <?php $subClass = $subObj ? $subitem->class ?? '' : ''; ?>
        <?php $subLabel = $subObj ? $subitem->label ?? '' : $subitem; ?>
        <li<?=$subClass?' class="'.$subClass.'"':''?>><a href="<?=$subLink?>"><?=$subIcon?><span><?=$subLabel?></span></a></li>
        <?php endforeach; ?>
      </ul>
    </li>
    <?php endif; ?>
  <?php endforeach; ?>
  </ul>
</div>