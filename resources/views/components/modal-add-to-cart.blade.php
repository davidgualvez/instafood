<div class="ui longer test modal transition add-to-cart-modal">
  <i class="close icon"></i>
  <div class="header" id="add-to-cart-modal-pname"> 
    <div class="ui relaxed divided list"> 
        <div class="item">
            <i class="large github middle aligned icon"></i>
            <div class="content">
                <a id="add-to-cart-modal-pname" class="header"></a> 
            </div>
        </div>
    </div>
  </div>
  <div class="scrolling image content">
    <div class="ui medium image"> 
      <img src="https://semantic-ui.com/images/avatar2/large/rachel.png"> 
    </div>
    <div class="description">
      <h2 class="ui sub header">
        Price
      </h2>
      <span id="add-to-cart-modal-pprice"></span> 
      {{-- -- --}}
      <br>
      <br>
      <div class="ui mini labeled action input" style="margin-bottom: 10px;">
         <label for="amount" class="ui label">Qty</label>
         <input  id="add-to-cart-modal-txt-qty" disabled patter="[0-9]*" inputmode="numeric" step="1" min="0" value="1" type="text"> 
         <button id="add-to-cart-modal-btn-minus-qty" class="ui icon button">
             <i class="minus icon"></i>
         </button>
         <button id="add-to-cart-modal-btn-plus-qty" class="ui icon button">
             <i class="plus icon"></i>
         </button>
      </div> 
      {{-- -- --}}
      {{-- ===== --}}
      <div class="ui form">
        <div class="inline fields">  
          <div class="field">
            <div class="ui radio checkbox">
              <input type="radio" name="dinein-takeout" checked="checked">
              <label>DINE-IN</label>
            </div>
          </div>
          <div class="field">
            <div class="ui radio checkbox">
              <input type="radio" name="dinein-takeout">
              <label>TAKE-OUT</label>
            </div>
          </div> 
        </div>
      </div>
      {{-- ==== --}} 
      <div class="ui fluid accordion">
          <div class="title " style="width: 100%;">
              <i class="dropdown icon"></i>
              MODIFY ITEM
              <label style="float: right;"> ITEM NAME</label>
          </div>
          <div class="content box"  style="padding:10px;">
              <div class="ui form"> 
                  <div class="grouped fields">
                      <label for="fruit">Select your second favorite fruit:</label>
                      <div class="field">
                      <div class="ui radio checkbox">
                          <input type="radio" name="fruit" checked="" tabindex="0" class="hidden">
                          <label>Apples</label>
                      </div>
                      </div>
                      <div class="field">
                      <div class="ui radio checkbox">
                          <input type="radio" name="fruit" tabindex="0" class="hidden">
                          <label>Oranges</label>
                      </div>
                      </div>
                      <div class="field">
                      <div class="ui radio checkbox">
                          <input type="radio" name="fruit" tabindex="0" class="hidden">
                          <label>Pears</label>
                      </div>
                      </div>
                      <div class="field">
                      <div class="ui radio checkbox">
                          <input type="radio" name="fruit" tabindex="0" class="hidden">
                          <label>Grapefruit</label>
                      </div>
                      </div>
                  </div>
              </div>
          </div> 
      </div>
      {{-- ===== --}}
      {{-- == --}}
    </div>
  </div>
  <div class="actions" > 
    {{-- <h3 class="ui header" id="add-to-cart-modal-pprice"></h3> --}} 
    <span>
      <strong id="add-to-cart-modal-total">
       TOTAL ₱ 0.00
      </strong> 
    </span> 
   {{--  <div class="" id="add-to-cart-modal-pprice"></div> --}}
    <button id="add-to-cart-modal-btn" class="ui button positive">
        ADD TO CART
    </button>
  </div>
</div>