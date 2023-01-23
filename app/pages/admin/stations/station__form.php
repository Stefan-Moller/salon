<!-- Edit Modal -->
<div id="edit-modal" class="modal">
  <div class="modal-inner">
    <header>
      <h3 class="modal-title">Edit Station</h3>
      <a class="modal-close">Close X</a>
    </header>
    <form class="modal-body" method="post" novalidate>
      <div class="form-row hidden">
        <div class="field">
          <label>ID</label>
          <input class="input" type="text" name="id" value="">
        </div>
      </div>
      <div class="form-row">
        <div class="field required">
          <label>No</label>
          <input class="input" type="text" name="no" value="">
        </div>
      </div>      
      <div class="form-row">
        <div class="field required">
          <label>Name</label>
          <input class="input" type="text" name="name" value="">
        </div>
      </div>
      <div class="form-row">
        <div class="field required">
          <label>Colour</label>
          <input class="input" type="text" name="colour" value="">
        </div>
      </div>  
      <div class="form-row">
        <div class="field" data-type="Select">
          <label>Therapist</label>
          <select 
            name="def_therapist_id" 
            data-search="true" 
            data-value=""
            data-placeholder="- Select a therapist -">
            <?php foreach( $view->model->therapists as $t ): $lbl = "{$t->name}<small> - {$t->cell}</small>"; ?>
            <option value="<?=$t->id?>" title="<?=$lbl?>"><?="{$t->name} - {$t->cell}"?></option>
            <?php endforeach; ?>
          </select>           
        </div>
      </div>  
      <div class="form-row">
        <div class="field" data-type="Memo">
          <label>Note</label>
          <textarea class="input" name="notes"></textarea>
        </div>
      </div>
    </form>
    <footer>
      <button class="button" type="button" onclick="F1.onSubmit(event)">Submit</button>
    </footer>
  </div>
</div>