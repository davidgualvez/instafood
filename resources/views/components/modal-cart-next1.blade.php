<div class="ui modal cart-modal-next1">
  <i class="close icon"></i>
  <div class="header">Cart - Others</div>
  <div class="scrolling content">
{{-- //== --}}
    <div class="ui two column grid stackable">
        <div class="column box">
            <h3 class="ui header">
                <i class="icon universal access"></i>
                Head Count
            </h3>
            <div class="ui form">
                <div class="field">
                    <label>Regular</label>
                    <div class="ui mini labeled action input" >
                        <label for="amount" class="ui label"># </label>
                        <input   
                            disabled patter="[0-9]*" 
                            inputmode="numeric" 
                            step="1" 
                            min="0" 
                            value="0" 
                            type="text"> 

                        <button id=" " class="ui icon button">
                            <i class="minus icon"></i>
                        </button>
                        <button id=" " class="ui icon button">
                            <i class="plus icon"></i>
                        </button>
                    </div>    
                </div>
            </div>
            <div class="ui form">
                <div class="field">
                    <label>Senior/Pwd</label>
                    <div class="ui mini labeled action input" >
                        <label for="amount" class="ui label"># </label>
                        <input 
                            disabled patter="[0-9]*" 
                            inputmode="numeric" 
                            step="1" 
                            min="0" 
                            value="0" 
                            type="text"> 

                        <button id=" " class="ui icon button">
                            <i class="minus icon"></i>
                        </button>
                        <button id=" " class="ui icon button">
                            <i class="plus icon"></i>
                        </button>
                    </div>    
                </div>
            </div>  
        </div>

        <div class="column box">
            <p>
                ....
            </p>
        </div>
        
    </div>
    <div class="ui divider"></div>
{{-- //== --}}
  </div>
  <div class="actions">  
    <button class="ui green button" id="mc-btn-proceed">Finish</button>
    {{-- <div class="ui buttons fluid">  
        <button class="ui button">Prepaid</button>
        <div class="or"></div>
        <button class="ui green button">Postpaid</button>
    </div>  --}}
  </div>
</div>