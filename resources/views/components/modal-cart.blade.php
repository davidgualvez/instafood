<div class="ui modal cart-modal">
  <div class="header">Cart</div>
  <div class="scrolling content">
{{-- //== --}}
<section class="ui basic vertical segment sticky cart" >   
                {{-- <h2 class="ui header">Cart</h2>  --}}
                <div class="ui divided animated list mc-list">  
                     
                     
                    <div class="item">
                        {{-- Remove Button --}}
                        <div class="right floated content">
                            <span>PHP 0.00</span>
                            <a href="" class="">
                                <i class="large red remove link icon"></i>
                            </a>
                        </div> 
                        {{-- ITEM --}}
                        {{-- <img class="ui avatar image" src="https://chap.website/wp-content/uploads/2013/06/hoodie_4_front.jpg"> --}}
                        <span class="ui avatar image " style="width:25px;">10x</span>
                        <div class="content">
                            <a class="header">TEST LAYOUT</a>
                            <div class="description" style="padding:0px!important;"> 
                                <div class="ui list">
                                    <div class="item">+ others</div> 
                                    <div class="item">+ others1</div> 
                                </div>
                            </div>
                        </div> 
                    </div>  

                </div> 
                {{-- <div class="ui buttons fluid">
                    <button class="ui button">Prepaid</button>
                    <div class="or"></div>
                    <button class="ui positive button">Postpaid</button>
                </div>  --}}
            </section>
{{-- //== --}}
  </div>
  <div class="actions"> 
    <div class="ui list"> 
        <div class="item">
            <div class="right floated content">
                <span class="amount right floated content">
                    <span class="">PHP</span>
                    <strong id="mc-subtotal">0.00</strong>
                </span>
            </div>
                <div class="left floated content" >
                Subtotal
                </div>
        </div>
        <div class="item">
            <div class="right floated content">
                <span class="amount right floated content">
                    <span class="">PHP</span>
                    <strong id="mc-total">0.00</strong>
                </span>
            </div>
                <div class="left floated content">
                Total <small>(Incl. VAT)</small>
                </div>
        </div>
    </div> 
    <div class="ui divider"></div>
    <div class="ui buttons fluid">
        <button class="ui button">Prepaid</button>
        <div class="or"></div>
        <button class="ui green button">Postpaid</button>
    </div> 
  </div>
</div>