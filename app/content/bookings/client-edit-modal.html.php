<!-- Edit Client Modal -->
<div id="edit-client-modal" class="modal">
  <div class="modal-inner">
    <form method="post" novalidate>
      <header>
        <h3>Edit Client</h3>
        <a class="modal-close">Close X</a>
      </header>
      <div class="modal-body form-rows">
        <div class="form-row hidden">
          <div class="field">
            <label>ID</label>
            <input class="input" type="text" name="id" value="">
          </div>
        </div>
        <div class="form-row">
          <div class="field required" data-type="Name">
            <label>Name</label>
            <input class="input" name="name" type="text" tabindex="0">
          </div>
        </div>
        <div class="form-row">
          <div class="field required" data-type="Cell">
            <label>Cellphone</label>
            <input class="input" name="cell" type="tel" tabindex="0">
          </div>
        </div>
        <div class="form-row">
          <div class="field" data-type="Email">
            <label>Email</label>
            <input class="input" name="email" type="email" tabindex="0">
          </div>
        </div>
        <div class="form-row">
          <div class="field" data-type="Memo">
            <label>Notes</label>
            <textarea class="input" name="notes"></textarea>
          </div>
        </div>
      </div>
      <footer class="form-row">
        <button type="submit" class="button" name="__action__" value="save-client"
          onclick="F1.onSubmitClient(event)">Submit</button>
        <a href="javascript:void(0)" onclick="F1.onDeleteClient(event)">Delete</a>          
      </footer>
    </form>
  </div>
</div>