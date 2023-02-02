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
          <label>Treatment</label>
          <input class="input" type="text" name="short_desc" value="">
        </div>
      </div>      
      <div class="form-row">
        <div class="field required">
          <label>Duration</label>
          <input class="input" type="text" name="def_duration" value="">
        </div>
      </div>
      <div class="form-row">
        <div class="field required">
          <label>Price</label>
          <input class="input" type="text" name="def_price" value="">
        </div>
      </div>
      <div class="form-row">
        <div class="field required">
          <label>Unit</label>
          <input class="input" type="text" name="def_unit" value="">
        </div>
      </div>
    </form>
    <footer>
      <button class="button" type="button" onclick="F1.onSubmit(event)">Submit</button>
    </footer>
  </div>
</div>