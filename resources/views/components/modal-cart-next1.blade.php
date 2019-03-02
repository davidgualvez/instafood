<div class="ui modal cart-modal-next1">
  <i class="close icon"></i>
  <div class="header">Cart - Others</div>
  <div class="scrolling content">
{{-- //== --}}
    <div class="ui two column grid stackable">
        <div class="column">
            <h3 class="ui header">
                <i class="icon universal access"></i>
                Head Count
            </h3>
            <div class="ui form">
                <div class="field">
                    <label>Total Headcount</label>
                    <div class="ui mini labeled action input" >
                        <label for="amount" class="ui label"># </label>
                        <input   
                            id="cart-modal-next1-hc-regular"
                            disabled patter="[0-9]*" 
                            inputmode="numeric" 
                            step="1" 
                            min="0" 
                            value="0" 
                            type="text"> 

                        <button id="cart-modal-next1-hc-regular-btn-minus" class="ui icon button">
                            <i class="minus icon"></i>
                        </button>
                        <button id="cart-modal-next1-hc-regular-btn-plus" class="ui icon button">
                            <i class="plus icon"></i>
                        </button>
                    </div>    
                </div>
            </div>
            {{-- <div class="ui form">
                <div class="field">
                    <label>Senior/Pwd</label>
                    <div class="ui mini labeled action input" >
                        <label for="amount" class="ui label"># </label>
                        <input 
                            id="cart-modal-next1-hc-cspwd"
                            disabled patter="[0-9]*" 
                            inputmode="numeric" 
                            step="1" 
                            min="0" 
                            value="0" 
                            type="text"> 

                        <button id="cart-modal-next1-hc-scpwd-btn-minus" class="ui icon button">
                            <i class="minus icon"></i>
                        </button>
                        <button id="cart-modal-next1-hc-scpwd-btn-plus" class="ui icon button">
                            <i class="plus icon"></i>
                        </button>
                    </div>    
                </div>
            </div>   --}}
        </div>

        <div class="column">
            <div class="ui form">
                <div class="field">
                    <label>Search by Mobile number</label>
                    <div class="ui mini labeled input">
                        <div class="ui label">
                            +63
                        </div>
                        <input id="mc-next1-txt-mnum" type="text" placeholder="9xxxxxxxxx">
                        <button id="mc-next1-mnum-btn-search" class="ui icon button">
                            <i class="search icon"></i>
                        </button>
                    </div>
                </div> 
            </div>
            <div class="ui segment">
                <h4 class="ui header">Result</h4>
                <div class="ui divider"></div> 
                <div id="mc-next1-customer-result">
                </div>
            </div>
        </div>
        
    </div>
    {{-- <div class="ui divider"></div> --}}
{{-- //== --}}
  </div>
  <div class="actions">  
    <button class="ui green button" id="mc-next1-btn-finish">Finish</button>
    {{-- <div class="ui buttons fluid">  
        <button class="ui button">Prepaid</button>
        <div class="or"></div>
        <button class="ui green button">Postpaid</button>
    </div>  --}}
  </div>
</div>