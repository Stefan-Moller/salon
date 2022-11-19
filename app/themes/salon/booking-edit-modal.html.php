<!-- Appointment Edit Modal -->
<section id="booking-edit-modal" class="modal">
  <form class="modal-inner" method="post" novalidate>
    <header>
      <h3>Book Appointment</h3>
      <a class="modal-close" onclick="F1.Modal.close(this,event)">Close X</a>
    </header>
    <div class="modal-body">
      <p class="field hidden">
        <label>ID</label>
        <input class="input" type="text" name="id" value="">
      </p>
      <p class="field required" data-type="Select">
        <label>Client</label>
        <select 
          name="client_id" 
          data-locale="en" 
          data-search="true" 
          data-value=""
          data-placeholder="- Select a client -">
          <?php foreach( $cal->clients as $c ): $lbl = "{$c->name}<small> - {$c->cell}</small>"; ?>
          <option value="<?=$c->id?>" title="<?=$lbl?>"><?="{$c->name} - {$c->cell}"?></option>
          <?php endforeach; ?>
        </select>
      </p>
      <p class="field required" data-type="Select">
        <label>Treatment</label>
        <select 
          name="treatment_id" 
          data-locale="en" 
          data-search="true" 
          data-value=""
          data-placeholder="- Select a treatment -">
          <?php foreach( $cal->treatments as $treatment ): ?>
          <option value="<?=$treatment->id?>"><?=$treatment->short_desc?></option>
          <?php endforeach; ?>
        </select>          
      </p>
      <div class="row" style="gap:1rem;margin-top:1rem">
        <div class="col" style="flex:1">
          <p class="field required" data-type="Select">
            <label>Therapist</label>
            <select 
              name="therapist_id" 
              data-locale="en" 
              data-search="true" 
              data-value=""
              data-placeholder="- Select a therapist -">
              <?php foreach( $cal->therapists as $t ): $lbl = "{$t->name}<small> - {$t->cell}</small>"; ?>
              <option value="<?=$t->id?>" title="<?=$lbl?>"><?="{$t->name} - {$t->cell}"?></option>
              <?php endforeach; ?>
            </select>           
          </p>
        </div>
        <div class="col" style="flex:1">
          <p class="field required" data-type="Select">
            <label>Station</label>
            <!-- data-multiple="true"  -->
            <select 
              name="station_id" 
              data-locale="en"
              data-search="true"
              data-value=""
              data-placeholder="- Select a station -">
              <!-- <optgroup title="Main Group"> -->
              <?php foreach( $cal->stations as $s ): $lbl = "STATION {$s->no}<small> - {$s->name}</small>"; ?>
              <option value="<?=$s->id?>" title="<?=$lbl?>"><?="STATION {$s->no} - {$s->name}"?></option>
              <?php endforeach; ?>
              <!-- </optgroup> -->
            </select>
          </p>
        </div>
      </div>
      <div class="row" style="gap:1rem;margin-top:1rem">
        <div class="col" style="flex:1">
          <span id="vanilla-calendar-1">- Calendar goes here... -</span>
        </div>
        <div class="col" style="flex:1">
          <p class="field required" data-control="#vanilla-calendar-1" data-name="date" data-type="Calendar">
            <label>Date</label>
            <input class="input" name="date" type="text" value="" 
              placeholder="- Use calendar to select -" 
              style="width:100%" autocomplete="off">
          </p>
          <div class="field required" data-name="time" data-type="Time">
            <label>Time</label>
            <div class="row" style="gap:0.67rem;align-items: flex-start;">
              <div class="input-container">
                <select class="input" name="start_hour">
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
              </div>
              <label style="padding:3px 0">:</label>
              <div class="col input-container" style="flex:1">
                <select class="input" name="start_min">
                  <option value="00">00</option>
                  <option value="15">15</option>
                  <option value="30">30</option>
                  <option value="45">45</option>
                </select>
              </div>
            </div>
          </div>            
          <p class="field required" data-type="Duration">
            <label>Duration</label>
            <span class="range-input">
              <input class="input" name="duration" type="range" value="0" min="0" max="120" step="15" list="dur">
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
          </p>
        </div>
      </div>
      <div class="row" style="gap:1rem;margin-top:1rem">
        <div class="col" style="flex:1">
          <p class="field mb0" data-type="Memo">
            <label>Note</label>
            <textarea class="input" name="notes"></textarea>
          </p>
        </div>
      </div>
    </div>      
    <footer>
      <button type="submit" class="button" name="__action__" value="save"
        onclick="F1.onSubmitBooking(event)">Submit</button>
    </footer>
  </form>
</section>