<div id="row-[data.id]" class="list-row" >
  <div>[data.short_desc]</div>
  <div>[data.def_duration]</div>
  <div>[data.def_price]</div>
  <div>[data.def_unit]</div>
  <div class="actions">
    <button class="button button-edit button-icon button-sm" type="button" 
      onclick="F1.onEdit(event,[data.id])"><img src="img/edit-24.png"></button>
    <button class="button button-delete button-icon button-sm hidden" type="button"
      onclick="F1.onDelete(event,[data.id])">x</button>
  </div>
</div>