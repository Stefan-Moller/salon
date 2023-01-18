<header id="main-header" class="main-header">
  <h2><?=$view->title?></h2>
  <div class="loading-indicator"><i></i><i></i><i></i><i></i></div>
  <button class="button add-button" type="button" onclick="F1.onAddNew(event)">
    <span class="trim"><i>+</i>&nbsp;New <?=isset($view->model->itemType)?$view->model->itemType:'Item'?></span>
  </button>  
</header>