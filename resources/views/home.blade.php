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
    @include('layouts.top-menu')
    {{-- END NAVIGATION --}}

    {{-- SIDEBAR --}}
    @include('layouts.sidebar-nav')
    {{-- END OF SIDEBAR --}}

    <!-- CONTENT -->
    <div class="ui stackable grid container-fluid" style="margin:5px;"> 
        
        {{-- <div class="twelve wide column">   --}}
        <div class="column">  
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
            
            
            <div class="ui segment">
                <div class="ui middle aligned divided selection list" id="products_container"> 
                 
                </div>
            </div>
            

            

           {{--  <div class="ui five doubling cards step3" > 
                <div class="card">
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
                
            </div> --}}
            {{-- </div> --}}
            {{-- ==== ITEMS --}} 
        </div>

        {{-- <div class="four wide sidebar column" id="example1">
            <section class="ui basic vertical segment sticky cart" >   
                <h2 class="ui header">Cart</h2> 
                <div class="ui divided animated list">  
                     
                    <div class="item">
                    
                        <div class="right floated content">
                            <a href="" class="">
                                <i class="large red remove link icon"></i>
                            </a>
                        </div> 
                        
                        <img class="ui avatar image" src="https://chap.website/wp-content/uploads/2013/06/hoodie_4_front.jpg">
                        <div class="content">
                            <a class="header">TEST LAYOUT</a>
                            <div class="description">
                                1 × PHP 0.00 
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
                                <strong>0.00</strong>
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
                                <strong>0.00</strong>
                            </span>
                        </div>
                         <div class="left floated content">
                            Total <small>(Incl. VAT)</small>
                         </div>
                    </div>
                </div>  
                <div class="ui buttons fluid">
                    <button class="ui button">Prepaid</button>
                    <div class="or"></div>
                    <button class="ui positive button">Postpaid</button>
                </div> 
            </section>
        </div> --}}

    </div>
    <!-- END CONTENT -->  

    {{-- ADD TO CART MODAL --}}
    @include('components.modal-add-to-cart')
    {{-- END OF ADD TO CART MODAL --}}

    {{-- CUSTOMER REGISTRATION MODAL --}}
    @include('components.modal-customer-registration')
    {{-- END OF CUSTOMER REGISTRATION MODAL --}}

    {{-- CART MODAL --}}
    @include('components.modal-cart')
    {{-- END OF CART MODAL --}}


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