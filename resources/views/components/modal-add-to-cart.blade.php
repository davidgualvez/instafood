<div class="ui modal transition add-to-cart-modal longer">
  <i class="close icon"></i>
  <div class="header add-to-cart-modal-pname">  
  </div>
  <div class="image content">
    <div class="ui medium image">
      {{-- <img src="/images/avatar/large/chris.jpg"> --}}
      <h2 class="ui sub header">
        Price
      </h2>
      <span class="add-to-cart-modal-pprice" style=""></span> 
      {{-- -- --}}
      <br>
      <br>
      <div class="ui mini labeled action input" style="margin-bottom: 10px;">
         <label for="amount" class="ui label">Qty</label>
         <input  id="add-to-cart-modal-txt-qty" 
            disabled patter="[0-9]*" 
            inputmode="numeric" 
            step="1" 
            min="0" 
            value="1" 
            type="text"> 

         <button id="add-to-cart-modal-btn-minus-qty" class="ui icon button">
             <i class="minus icon"></i>
         </button>
         <button id="add-to-cart-modal-btn-plus-qty" class="ui icon button">
             <i class="plus icon"></i>
         </button>
      </div> 
      {{-- -- --}}
    </div>
    <div class="description">
      <div class="ui inverted dimmer">
        <div class="ui text loader">Loading</div>
      </div>
      {{-- ===== --}}
      <div class="ui form cart-food-dinein-takeout">
        <div class="inline fields">  
          <div class="field">
            <div class="ui radio checkbox">
              <input type="radio" name="add-to-cart-dinein-takeout" value="dine-in" checked="checked">
              <label>DINE-IN</label>
            </div>
          </div>
          <div class="field">
            <div class="ui radio checkbox">
              <input type="radio" name="add-to-cart-dinein-takeout" value="take-out">
              <label>TAKE-OUT</label>
            </div>
          </div> 
        </div>
      </div> 
      <div class="ui fluid accordion">
          <div class="title " style="width: 100%;">
              <i class="dropdown icon"></i>
              Click to change
              <label style="float: right;"> ITEM NAME (9)</label>
          </div>
          <div class="content box"  style="padding:10px;">
            <div class="ui middle aligned divided list">
              <div class="item">
                <div class="right floated content"> 
                  <strong>(0)</strong>
                  <div class="ui  green button">
                    <i class="minus icon"></i>
                  </div>
                  <div class="ui  red button">
                    <i class="plus icon"></i>
                  </div>
                </div>
                {{-- <img class="ui avatar image" src="/images/avatar2/small/lena.png"> --}}
                <div class="content">
                  Sprite ( ₱ 0.00 )
                </div>
              </div> 
              <div class="item">
                <div class="right floated content"> 
                  <strong>(0)</strong>
                  <div class="ui  green button">
                    <i class="minus icon"></i>
                  </div>
                  <div class="ui  red button">
                    <i class="plus icon"></i>
                  </div>
                </div>
                {{-- <img class="ui avatar image" src="/images/avatar2/small/lena.png"> --}}
                <div class="content">
                  Sprite ( ₱ 0.00 )
                </div>
              </div> 
              <div class="item">
                <div class="right floated content"> 
                  <strong>(0)</strong>
                  <div class="ui  green button">
                    <i class="minus icon"></i>
                  </div>
                  <div class="ui  red button">
                    <i class="plus icon"></i>
                  </div>
                </div>
                {{-- <img class="ui avatar image" src="/images/avatar2/small/lena.png"> --}}
                <div class="content">
                  Sprite ( ₱ 0.00 )
                </div>
              </div>  
            </div>
          </div> 
      </div>
      {{-- ===== --}}
      <div class="ui accordion">
          <div class="title">
              <i class="dropdown icon"></i>
              INSTRUCTIONS(Optional)
          </div>
          <div class="content" style="padding-bottom: 10px;">
              <div class="ui form transition hidden"> 
                  <div class="field"> 
                      <textarea id="add-to-cart-modal-instruction" rows="2" placeholder="e.g. no onions, no mayo 
Write comments in case you are allergic to ingredients or want to exclude some."></textarea>
                  </div>
              </div>
          </div> 
      </div>
      {{-- ===== --}} 
      <div style="width: 500px;"></div> 
    </div>
  </div>
  <div class="actions"> 
    <span>
      TOTAL ₱
      <strong id="add-to-cart-modal-total">
        
      </strong> 
    </span>  
    <button id="add-to-cart-modal-btn" class="ui button ">
        ADD TO CART
    </button>
  </div>
</div>
 