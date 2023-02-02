<!-- Edit Modal -->
<div id="edit-modal" class="modal">
  <div class="modal-inner">
    <header>
      <h3 class="modal-title">Edit Station</h3>
      <a class="modal-close">Close X</a>
    </header>
    <form class="modal-body" method="post" novalidate> 
      <div class="form-row">
        <div class="field required">
          <label>Name</label>
          <input class="input" type="text" name="name" value="">
        </div>
      </div>
      <div class="form-row">
        <div class="field required">
          <label>Cell</label>
          <input class="input" type="text" name="cell" value="">
        </div>
        <div class="form-row">
        <div class="field">
          <label>Email</label>
          <input class="input" type="text" name="name" value="">
        </div>
      </div>     
      </div>     
      <div class="form-row">
        <div class="field required">
          <label>Colour</label>
          <input class="input" type="text" name="colour" value="">
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