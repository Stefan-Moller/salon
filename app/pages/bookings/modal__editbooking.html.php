<!-- Edit Booking Modal -->
<div id="edit-booking-modal" class="modal">
  <div class="modal-inner">
    <header>
      <h3>Book Appointment</h3>
      <a class="modal-close">Close X</a>
    </header>
    <form class="modal-body" method="post" novalidate>
      <div class="form-row hidden">
        <div class="field">
          <label>ID</label>
          <input class="input" type="text" name="id" value="">
        </div>
      </div>
      <div class="form-row client">
        <div class="field required" data-type="Select">
          <label>Client</label>
          <select 
            name="client_id" 
            data-search="true" 
            data-value=""
            data-placeholder="- Select a client -"
            onchange="F1.onClientChanged(event)">
            <?php foreach( $view->model->clients as $c ): $lbl = "{$c->name}<small> - {$c->cell}</small>"; ?>
            <option value="<?=$c->id?>" title="<?=$lbl?>"><?="{$c->name} - {$c->cell}"?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="flex">
          <button class="button button-edit button-icon button-sm" type="button" onclick="F1.onEditClient(event)">
            <img src="img/edit-24.png" width="12" height="12"></button>
          <button class="button button-add button-icon button-sm" type="button" onclick="F1.onNewClient(event)">+</button>
        </div>
      </div>
      <div class="form-row">
        <div class="field required" data-type="Select">
          <label>Treatment</label>
          <select 
            name="treatment_id" 
            data-search="true" 
            data-value=""
            data-placeholder="- Select a treatment -">
            <?php foreach( $view->model->treatments as $treatment ): ?>
            <option value="<?=$treatment->id?>"><?=$treatment->short_desc?></option>
            <?php endforeach; ?>
          </select>          
        </div>
      </div>
      <div class="form-row">
        <div class="field required" data-type="Select">
          <label>Therapist</label>
          <select 
            name="therapist_id" 
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
        <div class="field required" data-type="Select">
          <label>Station</label>
          <!-- data-multiple="true"  -->
          <select 
            name="station_id" 
            data-search="true"
            data-value=""
            data-placeholder="- Select a station -">
            <!-- <optgroup title="Main Group"> -->
            <?php foreach( $view->model->stations as $s ): $lbl = "STATION {$s->no}<small> - {$s->name}</small>"; ?>
            <option value="<?=$s->id?>" title="<?=$lbl?>"><?="STATION {$s->no} - {$s->name}"?></option>
            <?php endforeach; ?>
            <!-- </optgroup> -->
          </select>
        </div>
      </div>
      <div class="form-row">
        <div id="booking-calendar" class="calendar">
          - Calendar goes here... -
        </div>
        <div class="form-rows" style="flex:1">
          <div class="form-row">
            <div class="date-input field required" data-control="#booking-calendar" data-name="date" data-type="Calendar">
              <label>Date</label>
              <input class="input" name="date" type="text" value="" tabindex="0" 
                placeholder="- Use calendar to select -" autocomplete="off">
            </div>
          </div>
          <div class="form-row">
            <div class="field required" data-name="time" data-type="Time">
              <label>Time</label>
              <div class="time-input">
                <select class="input" name="start_hour" tabindex="0">
                  <option value="07">07</option>
                  <option value="08">08</option>
                  <option value="09">09</option>
                  <option value="10">10</option>
                  <option value="11">11</option>
                  <option value="12">12</option>
                  <option value="13">13</option>
                  <option value="14">14</option>
                  <option value="15">15</option>
                  <option value="16">16</option>
                  <option value="17">17</option>
                  <option value="18">18</option>
                  <option value="19">19</option>
                </select>
                <span> : </span>
                <select class="input" name="start_min" tabindex="0">
                  <option value="00">00</option>
                  <option value="15">15</option>
                  <option value="30">30</option>
                  <option value="45">45</option>
                </select>
              </div>
            </div>
          </div>
          <div class="form-row">
            <div class="field required" data-type="Duration">
              <label>Duration</label>
              <span class="range-input">
                <input class="input" name="duration" type="range" value="0" min="0" max="120" step="15" list="dur" tabindex="0">
                <label class="duration_disp">15min</label>
                <datalist id="dur">
                <option value="15"  label="15min"></option>
                <option value="30"  label="30min"></option>
                <option value="45"  label="45min"></option>
                <option value="60"  label="1h"></option>
                <option value="75"  label="1h15"></option>
                <option value="90"  label="1h30"></option>
                <option value="105" label="1h45"></option>
                <option value="120" label="2h"></option>
                </datalist>
              </span>
            </div>
          </div>
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
      <button class="button" type="button" onclick="F1.onSubmitBooking(event)">Submit</button>
    </footer>
  </div>
</div>