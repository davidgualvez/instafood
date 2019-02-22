<div class="ui modal transition modal-customer-registration longer">
  <i class="close icon"></i>
  <div class="header">  
    CUSTOMER REGISTRATION
  </div>
  <div class="image content">
    <div class="ui medium image">
      {{-- <img src="/images/avatar/large/chris.jpg"> --}}
      <div class="ui form">
          <div class="field">
              <label class="" style="text-align: left;">Name</label>
              <div class="ui left icon input">
                <i class="user icon"></i>
                <input type="text" id="modal-cr-name" placeholder="Name" value=""> 
              </div> 
          </div> 
          <div class="field">
            <label class="" style="text-align: left;">Birthdate</label>
            <div class="ui left icon input">
              <i class="gift icon"></i>
              <input type="date" id="modal-cr-bdate" placeholder="Birthdate" value="">
            </div>
          </div>
      </div>

    </div>
    <div class="description">   
      <div class="ui form">
        <div class="field">
          <label class="" style="text-align: left;">Mobile number</label> 
          <div class="ui labeled input">
              <div class="ui label">
                  +63
              </div>
              <input type="text" id="modal-cr-mobile_number" placeholder="ex. 9xxxxxxxxx" value="">
          </div>
        </div>
      </div>
      <div style="width: 500px;"></div> 
    </div>
  </div>
  <div class="actions">   
    <button id="modal-btn-customer-register" class="ui green button ">
        REGISTER
    </button>
  </div>
</div>
 