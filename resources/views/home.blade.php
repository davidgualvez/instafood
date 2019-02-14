<!DOCTYPE html>
<html>
<head> 
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" /> 
	<meta name=viewport content="width=device-width, initial-scale=1">
	<meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" type="image/x-icon" href="/favico.png" />
    <title>Main | EK Restaurant</title>

	<!-- CSS -->
	<link rel="stylesheet" type="text/css" href="/dist/semantic.min.css"> 
	<link rel="stylesheet" type="text/css" href="/css/plugins/introjs.min.css">
    <link rel="stylesheet" type="text/css" href="/css/plugins/iziToast.min.css">
	<link rel="stylesheet" type="text/css" href="/css/config.css">
	<!-- CUSTOM CSS --> 
	<style type="text/css"> 
        .ui.basic.vertical.segment.sticky.cart.fixed.top {
            margin-top: 40px!important;
        }
        .ui.basic.vertical.segment.sticky.cart {
            margin-top: 20px!important;
        }

        .add-to-cart-modal-panel{
            text-align: left;
        }
	</style>
</head>
<body>  
    {{-- NAVIGATION --}}
    {{-- <div class="ui sticky" style="width: 670px !important; height: 43px !important; left: 456.5px;"> --}}
    <div class="ui top fixed mini menu">
        <a id="sidebar-menu" class="item">
            <i class="bars icon"></i>
        </a>  
        <div class="item">
            Welcome! &nbsp;<strong id="employee_name"></strong>
        </div>
        <div class="item">
            <strong>HOME </strong>
        </div>

        <div class="right menu">
            <a href="" class="item">
                <i class="sync green icon"></i> 
            </a> 
            <div class="item" id="clock"> 
            </div>
            <div class="item"> 
                <div class="ui purple label mini">
                    <i class="cart icon"></i> 22
                </div> 
            </div>
            <a id="sidebar-menu" class="item  btn-signout">
                    <i class="sign-out icon"></i>
                    Signout
            </a> 
        </div>
    </div>
    {{-- </div> --}}
    {{-- END NAVIGATION --}}

    {{-- SIDEBAR --}}
    <div class="ui sidebar  vertical menu"> 
    	<a class="active item">
            Enchanted Kingdom
        </a>  
         <a class="item">
            <i class=" icon"></i>
            Order History
        </a>  
    </div>
    {{-- END OF SIDEBAR --}}
    <!-- CONTENT -->
    <div class="ui stackable grid container-fluid" style="margin:5px;"> 
        
        <div class="twelve wide column">  
            <br>
            {{-- ======= --}}
            <div class="ui secondary menu"> 
                <div class="ui multiple dropdown group" tabindex="0">
                <input type="hidden" name="filters">
                <i class="filter icon"></i>
                <span class="text step1">Select Categories</span>
                <div class="menu transition hidden" tabindex="-1">
                    <div class="ui icon search input">
                    <i class="search icon"></i>
                    <input type="text" placeholder="Search tags...">
                    </div>
                    <div class="divider"></div>
                    <div class="header">
                    <i class="tags icon"></i>
                    Tag Label
                    </div>
                    <div class="scrolling menu" id="categories"><div class="categories item" data-value="10211">ALA CARTE</div><div class="categories item" data-value="10101">APPAREL</div><div class="categories item" data-value="10302">BUNDLED TICKETS</div><div class="categories item" data-value="10203">CONDIMENTS</div><div class="categories item" data-value="10201">FFS  SNCKCMBO</div><div class="categories item" data-value="10206">FFS BEVERAGE</div><div class="categories item" data-value="10202">FFS FG</div><div class="categories item" data-value="10208">FOOD</div><div class="categories item" data-value="10205">FOOD PACKAGING</div><div class="categories item" data-value="10402">LOAD WALLET</div><div class="categories item" data-value="10207">MEALGROUP</div><div class="categories item" data-value="10102">OTHER</div><div class="categories item" data-value="10209">OTHER</div><div class="categories item" data-value="10104">PEN</div><div class="categories item" data-value="10401">PREPAID CARD</div><div class="categories item" data-value="10303">PROMO TICKETS</div><div class="categories item" data-value="10212">RAW MATERIALS</div><div class="categories item" data-value="10204">RECIPE</div><div class="categories item" data-value="10301">REGULAR TICKETS</div><div class="categories item" data-value="10210">SPICES</div><div class="categories item" data-value="10103">TUMBLER</div></div>
                </div>
                </div>

                <div class="right menu">
                    <div class="item">
                    <div class="ui icon input step2">
                        <input type="text" id="search_our_products" placeholder="Search products...">
                        <i class="search link icon" id="btn_search_our_products"></i>
                    </div>
                    </div>
                </div>
            </div> 
            {{-- ======= ITEMS --}}
            {{-- <div class="ui loading segment"> --}}
                {{-- <div class="ui active inverted dimmer">
                    <div class="ui text loader">Loading Products</div>
                </div> --}}
            <div class="ui five doubling cards step3" id="products_container"> 
                {{-- <div class="card">
                    <div class="image"> 
                        <img class="product_image add-to-cart" src="https://chap.website/wp-content/uploads/2017/01/pexels-photo-300x300.jpg">
                    </div>
                        <div class="content">
                            <div class="header">TEST</div>
                            <div class="meta">
                            </div>
                            <div class="description">TEST</div>
                        </div>
                        <div class="extra content"> 

                            <div class="ui small header">   
                                <span class=" ">
                                    <span class=" ">
                                        Php
                                    </span>
                                    15.00
                                </span>
                            </div>
                            
                        </div>
                        <div class="ui violet bottom attached button add-to-cart">
                            <i class="add icon"></i>
                                Add to Cart
                        </div>
                </div>   
                 --}}
            </div>
            {{-- </div> --}}
            {{-- ==== ITEMS --}} 
        </div>

        <div class="four wide sidebar column" id="example1">
            <section class="ui basic vertical segment sticky cart" >   
                <h2 class="ui header">Cart</h2> 
                <div class="ui divided animated list">  
                     
                    <div class="item">
                        {{-- Remove Button --}}
                        <div class="right floated content">
                            <a href="" class="">
                                <i class="large red remove link icon"></i>
                            </a>
                        </div> 
                        {{-- ITEM --}}
                        <img class="ui avatar image" src="https://chap.website/wp-content/uploads/2013/06/hoodie_4_front.jpg">
                        <div class="content">
                            <a class="header">YANGCHOW RICE</a>
                            <div class="description">
                                1 × PHP 25.00 
                            </div>
                        </div>

                    </div>
                    <div class="item">
                        {{-- Remove Button --}}
                        <div class="right floated content">
                            <a href="" class="">
                                <i class="large red remove link icon"></i>
                            </a>
                        </div> 
                        {{-- ITEM --}}
                        <img class="ui avatar image" src="https://chap.website/wp-content/uploads/2013/06/hoodie_4_front.jpg">
                        <div class="content">
                            <a class="header">YANGCHOW RICE</a>
                            <div class="description">
                                1 × PHP 25.00 
                            </div>
                        </div>

                    </div>
                    <div class="item">
                        {{-- Remove Button --}}
                        <div class="right floated content">
                            <a href="" class="">
                                <i class="large red remove link icon"></i>
                            </a>
                        </div> 
                        {{-- ITEM --}}
                        <img class="ui avatar image" src="https://chap.website/wp-content/uploads/2013/06/hoodie_4_front.jpg">
                        <div class="content">
                            <a class="header">YANGCHOW RICE</a>
                            <div class="description">
                                1 × PHP 25.00 
                            </div>
                        </div>

                    </div>
                    <div class="item">
                        {{-- Remove Button --}}
                        <div class="right floated content">
                            <a href="" class="">
                                <i class="large red remove link icon"></i>
                            </a>
                        </div> 
                        {{-- ITEM --}}
                        <img class="ui avatar image" src="https://chap.website/wp-content/uploads/2013/06/hoodie_4_front.jpg">
                        <div class="content">
                            <a class="header">YANGCHOW RICE</a>
                            <div class="description">
                                1 × PHP 25.00 
                            </div>
                        </div>

                    </div>
                    <div class="item">
                        {{-- Remove Button --}}
                        <div class="right floated content">
                            <a href="" class="">
                                <i class="large red remove link icon"></i>
                            </a>
                        </div> 
                        {{-- ITEM --}}
                        <img class="ui avatar image" src="https://chap.website/wp-content/uploads/2013/06/hoodie_4_front.jpg">
                        <div class="content">
                            <a class="header">YANGCHOW RICE</a>
                            <div class="description">
                                1 × PHP 25.00 
                            </div>
                        </div>

                    </div>
                    <div class="item">
                        {{-- Remove Button --}}
                        <div class="right floated content">
                            <a href="" class="">
                                <i class="large red remove link icon"></i>
                            </a>
                        </div> 
                        {{-- ITEM --}}
                        <img class="ui avatar image" src="https://chap.website/wp-content/uploads/2013/06/hoodie_4_front.jpg">
                        <div class="content">
                            <a class="header">YANGCHOW RICE</a>
                            <div class="description">
                                1 × PHP 25.00 
                            </div>
                        </div>

                    </div>
                    <div class="item">
                        {{-- Remove Button --}}
                        <div class="right floated content">
                            <a href="" class="">
                                <i class="large red remove link icon"></i>
                            </a>
                        </div> 
                        {{-- ITEM --}}
                        <img class="ui avatar image" src="https://chap.website/wp-content/uploads/2013/06/hoodie_4_front.jpg">
                        <div class="content">
                            <a class="header">YANGCHOW RICE</a>
                            <div class="description">
                                1 × PHP 25.00 
                            </div>
                        </div>

                    </div>
                    <div class="item">
                        {{-- Remove Button --}}
                        <div class="right floated content">
                            <a href="" class="">
                                <i class="large red remove link icon"></i>
                            </a>
                        </div> 
                        {{-- ITEM --}}
                        <img class="ui avatar image" src="https://chap.website/wp-content/uploads/2013/06/hoodie_4_front.jpg">
                        <div class="content">
                            <a class="header">YANGCHOW RICE</a>
                            <div class="description">
                                1 × PHP 25.00 
                            </div>
                        </div>

                    </div>
                    <div class="item">
                        {{-- Remove Button --}}
                        <div class="right floated content">
                            <a href="" class="">
                                <i class="large red remove link icon"></i>
                            </a>
                        </div> 
                        {{-- ITEM --}}
                        <img class="ui avatar image" src="https://chap.website/wp-content/uploads/2013/06/hoodie_4_front.jpg">
                        <div class="content">
                            <a class="header">YANGCHOW RICE</a>
                            <div class="description">
                                1 × PHP 25.00 
                            </div>
                        </div>

                    </div>
                    <div class="item">
                        {{-- Remove Button --}}
                        <div class="right floated content">
                            <a href="" class="">
                                <i class="large red remove link icon"></i>
                            </a>
                        </div> 
                        {{-- ITEM --}}
                        <img class="ui avatar image" src="https://chap.website/wp-content/uploads/2013/06/hoodie_4_front.jpg">
                        <div class="content">
                            <a class="header">YANGCHOW RICE</a>
                            <div class="description">
                                1 × PHP 25.00 
                            </div>
                        </div>

                    </div>
                    <div class="item">
                        {{-- Remove Button --}}
                        <div class="right floated content">
                            <a href="" class="">
                                <i class="large red remove link icon"></i>
                            </a>
                        </div> 
                        {{-- ITEM --}}
                        <img class="ui avatar image" src="https://chap.website/wp-content/uploads/2013/06/hoodie_4_front.jpg">
                        <div class="content">
                            <a class="header">YANGCHOW RICE</a>
                            <div class="description">
                                1 × PHP 25.00 
                            </div>
                        </div>

                    </div> 
                </div>

                <div class="ui divider"></div>
                <div class="ui list"> 
                    <div class="item">
                        <div class="right floated content">
                            <span class="amount right floated content">
                                <span class="">PHP</span>
                                <strong>102.00</strong>
                            </span>
                        </div>
                         <div class="left floated content">
                            Subtotal
                         </div>
                    </div>
                    <div class="item">
                        <div class="right floated content">
                            <span class="amount right floated content">
                                <span class="">PHP</span>
                                <strong>102.00</strong>
                            </span>
                        </div>
                         <div class="left floated content">
                            Total <small>(Incl. VAT)</small>
                         </div>
                    </div>
                </div> 
{{-- ==== --}}
<div class="ui accordion">
    <div class="title">
        <i class="dropdown icon"></i>
        INSTRUCTIONS(Optional)
    </div>
    <div class="content" style="padding-bottom:10px;">
        <div class="ui form"> 
            <div class="field"> 
                <textarea rows="2" placeholder="e.g. no onions, no mayo &#10;Write comments in case you are allergic to ingredients or want to exclude some."></textarea>
            </div>
        </div>
    </div> 
</div>
<br>
{{-- ==== --}}
                <div class="ui buttons fluid">
                    <button class="ui button">Prepaid</button>
                    <div class="or"></div>
                    <button class="ui positive button">Postpaid</button>
                </div> 
            </section>
        </div>

    </div>
    <!-- END CONTENT -->  

    {{-- ADD TO CART MODAL --}}
    <div class="ui dimmer add-to-cart-modal">
        <div class="content"> 

<div class="ui card add-to-cart-modal-panel"  style="color:black; width:650px;">
  <div class="content"> 
    <a id="add-to-cart-modal-close"><i class="right floated close large icon "></i></a> 
    <div class="header">
        {{-- Cute Dog --}}
        <div class="ui relaxed divided list"> 
            <div class="item">
                <i class="large github middle aligned icon"></i>
                <div class="content">
                    <a id="add-to-cart-modal-pname" class="header"></a>
                    <div id="add-to-cart-modal-pprice" class="description"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="description">
{{-- ==== --}}
<div class="ui accordion">
                <div class="title">
                <i class="dropdown icon"></i>
                MODIFY ITEM
                </div>
                <div class="content"  style="padding:10px;">
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
{{-- ==== --}}
    </div>
  </div>
  <div class="extra content">
    <div class="ui right labeled action input">
        <label for="amount" class="ui label">Qty</label>
        <input  id="add-to-cart-modal-txt-qty" disabled patter="[0-9]*" inputmode="numeric" step="1" min="0" value="1" type="text"> 
        <button id="add-to-cart-modal-btn-minus-qty" class="ui icon button">
            <i class="minus icon"></i>
        </button>
        <button id="add-to-cart-modal-btn-plus-qty" class="ui icon button">
            <i class="plus icon"></i>
        </button>
    </div> 
    <button id="add-to-cart-modal-btn" class="ui button right floated right positive">
        ADD TO CART
    </button> 
  </div>
</div>

        </div>
    </div>
    {{-- END OF ADD TO CART MODAL --}}

	<!-- JS -->
	<script src="/js/app.js"></script>
	<script src="/dist/semantic.min.js"></script>
    <script src="/js/plugins/iziToast.min.js"></script>
    <script src="/js/plugins/moment.js"></script>
	<script src="/js/config.js"></script>
	<!-- CUSTOM JS --> 
	<script src="/js/pages/home.js"></script> 
</body>
</html> 