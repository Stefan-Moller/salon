<div id="row-[data.id]" class="list-row" data-no="[data.no]">
  <div>[data.no]</div>
  <div>[data.name]</div>
  <div>[data.therapist]</div>
  <div><span class="colour-disp" style="background-color:[data.colour]">[data.colour]</span></div>
  <div>[data.notes]</div>
  <div class="actions">
    <button class="button button-edit button-icon button-sm" type="button" 
      onclick="F1.onEdit(event,[data.id])"><img src="img/edit-24.png"></button>
    <button class="button button-delete button-icon button-sm hidden" type="button"
      onclick="F1.onDelete(event,[data.id])">x</button>
  </div>
</div>