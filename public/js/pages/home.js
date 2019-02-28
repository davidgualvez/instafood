"use strict";

$(document).ready(function(){
    console.log('loaded...');

    if(!isLogin()){
        redirectTo('/login');
        return;
    } 
 
    $('.ui.accordion').accordion();
    $('.ui.radio.checkbox').checkbox();
    
    getCategories();
    paginateProduct();
   
    $('.ui.multiple.dropdown.group').dropdown('setting', 'onChange', function () {
        current_page_product = 1;
        paginateProduct();
        console.log('change...');
    });

    displayName();
    updateCartCount();
});

//global
let product_lists ;
let selected_product;

//pagination================================ 
var current_page_product = null;
var prev_page_url_product = null;
var next_page_url_product = null;
var current_data_product = null;

function paginateProduct() {
    //
    var filtered_value = $('.ui.multiple.dropdown.group').dropdown('get value');
    var selected_categories = filtered_value.split(",");
    //
    // var limit = $('#limit_product').val();
    var search_val = $('#search_our_products').val();

    var data = {
        search: search_val,
        // limit: limit,
        categories: selected_categories
    };
 
    var url = null;

    if (current_page_product == null) {
        current_page_product = 1;
    }
 
    //=============
    postWithHeader(routes.product.list + "?page=" + current_page_product, data, function (response) {
        if (response.success == false) {

            if (response.status == 401) {
                showWarning('FORBIDDEN', response.message, function () {
                    logout();
                });
                return;
            }

        } 

        current_page_product = response.data.current_page; 
        var items = response.data.data;  
        dataDisplayerProduct(items, response.data.from);


        if (response.data.next_page_url != null){ 
            current_page_product++;
            paginateProduct();
        }else{

            // $('.ui.sticky').sticky({
            //     context: '#example1'
            // });

            btnAddToCart(); 
            console.log(product_lists);
        }
    });
    //============= 
}

function btnNextProduct() {
    $('#next_page_url_product').on('click', function () {
        current_page_product++;
        paginateProduct();
    });
}

function btnPrevProduct() {
    $('#prev_page_url_product').on('click', function () {
        current_page_product--;
        paginateProduct();
    });
}

function limitOnChangeProduct() {
    $('#limit_product').on('change', function () {
        current_page_product = 1;
        paginateProduct();
    });
}

function dataDisplayerProduct(data, from) {
    var items = $('#products_container');

    if (current_page_product == 1){
        items.empty();
    } 

    if (from == null) {
        $('#current_page_product').html('Nothing to display...');
        showWarning('', 'No Result...', function () { 
        }); 
        return;
    }

    if(from == 1){
        product_lists   = new Map();
        console.log('weakmap');
    }

    current_data_product = data;
    $.each(data, function (key, value) {
        var category = value.group_name;
        items.append( 
            '<div class="item product" data-id="'+from+'" >'+
              '<div class="right floated content">'  +
                '<a class="ui violet tag label right floated">₱ '+value.srp +'</a>'+
              '</div>'+
              // '<strong>'+ (from) +'</strong>&nbsp; '+
              // '<img class="ui avatar image" src="https://semantic-ui.com/images/avatar/small/daniel.jpg">'+
              '<div class="content" >'+
                  '<a class="header">'+value.description+'</a>' +
              '</div>'+
            '</div>'   
        );
 
        product_lists.set(from,value);
        from++; 
    });     
}
//end of pagination================

function getCategories() { 
    postWithHeader(routes.product.groups, {}, function (response) {
        var cat = $('#categories');
        cat.empty();
        $.each(response.data, function (key, val) {
            //populate the categories from this response 
            cat.append(
                '<div class="categories item" data-value="' + val.group_id + '">' +
                val.description +
                '</div>'
            );
        });
    });
}

function getComponents(outlet_id = null,product_id = null){

    var data = {
        outlet_id : outlet_id
    } 
    postWithHeader(
        '/product/'+product_id+'/components',
        data, 
        function(response){

        var result = response.data;

        var mlist = $('.add-to-cart-modifiables'); // modifiable list
        mlist.empty();

        if( result.length > 0){
 
            $.each(result, function(k,v){
                if(v.modifiable == 1 || v.modifiable == '1'){
                    //console.log(v);

                    // add to components in select_product object
                    var item    = {
                        item: {
                            parent_id       : v.parent_id,
                            product_id      : v.product_id,
                            description     : v.description,
                            base_quantity   : parseInt(v.quantity),
                            product_category: v.product_category,
                            modifiable      : v.modifiable,
                            rp              : parseFloat(v.rp),
                            quantity        : parseInt(v.quantity)
                        },
                        qty: selected_product.ordered_qty,
                        selectable_items: []
                    }; 

                    // create modify content for each item
                    var qty     = selected_product.ordered_qty * v.quantity;
                    mlist.append(
                        '<div class="title " style="width: 100%;">'+
                            '<i class="dropdown icon"></i>'+
                            'Click to change'+
                            '<label style="float: right;" id="pc-' +v.product_id+'">'+v.description+' ( '+qty+' )</label>'+
                        '</div>' + 

                        '<div class="content"   style="padding:10px;">'+
                            '<div class="ui middle aligned divided list  add-to-cart-selectables" id="m-item-'+v.product_id+'">'+
                            '</div>'+
                        '</div>'
                    );


                    get('/products/group/'+v.product_category, {
                        outlet_id: getStorage('outlet_id')
                    }, function(response){

                        var selectable_container = $(".add-to-cart-selectables#m-item-"+v.product_id);
                        selectable_container.empty();

                        $.each(response.data, function(kk,vv){
                            var rp = 0;
                            if ( parseFloat(vv.srp) > parseFloat(v.rp)  ){
                                rp = parseFloat(vv.srp) - parseFloat(v.rp);
                            }
                            item.selectable_items.push({
                                category_id     : vv.category_id,
                                description     : vv.description,
                                short_code      : vv.short_code,  
                                is_food         : vv.is_food,
                                is_postmix      : vv.is_postmix,
                                outlet_id       : vv.outlet_id,
                                product_id      : vv.product_id,
                                price           : rp,
                                qty             : 0
                            });

                            selectable_container.append(
                                '<div class="item">'+
                                  '<div class="right floated content"> '+
                                    '<strong id="atc-pc'+v.product_id+'-spc'+vv.product_id+'">(0)</strong> &nbsp;'+
                                    '<div data-pc-id="'+v.product_id+'" data-spc-index="'+kk+'" class="btn-spc-minus ui  green button">'+
                                      '<i class="minus icon"></i>'+
                                    '</div>'+
                                    '<div data-pc-id="'+v.product_id+'" data-spc-index="'+kk+'" class="btn-spc-plus ui red button">'+
                                      '<i class="plus icon"></i>'+
                                    '</div>'+
                                  '</div>'+
                                  '<div class="content">'+
                                    vv.short_code + ' ( ₱ ' + numberWithCommas((rp).toFixed(2)) +' )'+
                                  '</div>'+
                                '</div>'
                            );
                        });

                        btnSpcMinus();
                        btnSpcPlus();

                    });
                    // display selectables
                    selected_product.components.push(item); 
                } 
            });
        }

    });
}


$('#btn_search_our_products').on('click', function () {
    current_page_product = 1;
    paginateProduct(); 
    console.log('change...');
});
$('#search_our_products').on('change', function () {
    current_page_product = 1;
    paginateProduct();
    
    console.log('change...');
}); 



function btnAddToCart(){
    $('.product').on('click', function(){
        console.log('product clicked.');
        // getting item from the selected
        let id = $(this).data('id');
        let item = product_lists.get(id);
        setSelectedItem(item);

        var addToCartModal = $('.ui.modal.transition.add-to-cart-modal.longer');
        //open loader 
        addToCartModal
        .children()
        .first()
        .next()
        .next()
        .children()
        .first()
        .next()
        .children()
        .first()
        .addClass('active') 

        addToCartModal.modal({
            transition: 'fade up',
            inverted: true,
            closable : true, 
            onHide: function(){
                console.log('hidden'); 
            },
            onShow: function(){
                console.log('shown');
            },
            onApprove: function() {
                console.log('Approve');
                // return validateModal()
            }
        }).modal('show'); 

        // get components if has
        getComponents(getStorage('outlet_id'),item.product_id);

        //qty set to 1
        $('#add-to-cart-modal-txt-qty').val(1);
        selected_product.ordered_qty = 1;

        //name
        $('.add-to-cart-modal-pname').text( item.description );

        //price
        $('.add-to-cart-modal-pprice').text('₱ '+ item.srp );

        //net amount
        $('#add-to-cart-modal-total').text( numberWithCommas( (selected_product.net_amount).toFixed(2) ) );


        // check if food  
        if( item.is_food !=1){
            $('.cart-food-dinein-takeout').hide();
            selected_product.order_type = 'take-out';
        }else{
            $('.cart-food-dinein-takeout').show();
            selected_product.order_type = 'dine-in';
        } 

        //close loader
        addToCartModal
        .children()
        .first()
        .next()
        .next()
        .children()
        .first()
        .next()
        .children()
        .first()
        .removeClass('active')  

        // 
        atcmDisplayUpdate();
        console.log(item,selected_product); 
    }); 
}
 
$('#add-to-cart-modal-close').on('click', function(){ 
    $('.ui.dimmer.add-to-cart-modal').dimmer('hide');
}); 
 
$('#add-to-cart-modal-btn-plus-qty').on('click', function(){
    var txtQty = $('#add-to-cart-modal-txt-qty');
    var netTotal = $('#add-to-cart-modal-total');
     
    var qty     = parseInt(txtQty.val()) + 1; 
    selected_product.ordered_qty = qty;

    //txtQty.val(qty); 
    //netTotal.text( numberWithCommas( (selected_product.net_amount).toFixed(2) ) );
    
    // loop all the parent component 
    $.each(selected_product.components, function(k,v){ 
        selected_product.components[k].qty += 1; 
        selected_product.components[k].item.quantity += selected_product.components[k].item.base_quantity * 1;  
    });   

    atcmDisplayUpdate();
}); 
 
$('#add-to-cart-modal-btn-minus-qty').on('click', function () {
    var txtQty = $('#add-to-cart-modal-txt-qty');
    var netTotal = $('#add-to-cart-modal-total');

    if (parseInt(txtQty.val()) > 1 ){
        var qty = parseInt(txtQty.val()) - 1;  
        selected_product.ordered_qty = qty; 

        $.each(selected_product.components, function(k,v){
            console.log('=======================');
            console.log(k,v);
            console.log(v.selectable_items);
            console.log(Object.keys(v.selectable_items).length );
            var si_length = Object.keys(v.selectable_items).length;
            var ctr = si_length;
            var tobe_deduct = selected_product.components[k].item.base_quantity * 1;

            for (var i = 0; i < si_length; i++){
                ctr --; 
                
                // if can deduct
                if (v.selectable_items[ctr].qty > 0){
                    console.log(v.selectable_items[ctr]);
                    if (tobe_deduct > selected_product.components[k].selectable_items[ctr].qty){
                        tobe_deduct = tobe_deduct - selected_product.components[k].selectable_items[ctr].qty;
                        selected_product.components[k].selectable_items[ctr].qty = 0;
                    }else{
                        selected_product.components[k].selectable_items[ctr].qty = selected_product.components[k].selectable_items[ctr].qty - tobe_deduct;
                        tobe_deduct = 0;
                        i = si_length;
                    } 
                    console.log(v.selectable_items[ctr]);
                }
                
            }

            console.log('tobe_deduct: ' + tobe_deduct);
            if(tobe_deduct > 0){
                console.log('TRUE: MAIN COMP');
                selected_product.components[k].item.quantity = selected_product.components[k].item.quantity - tobe_deduct;
                console.log('rQty: ' + selected_product.components[k].qty);
            }
            console.log('=======================');
        });
    }
     
    atcmDisplayUpdate();
}); 
 
$('#add-to-cart-modal-btn').on('click', function () { 
    console.log(selected_product);
    var now = moment();
    var beginning_of_now = moment(''+now.year()+'-'+now.month()+'-'+now.day());
    var id = now.diff(beginning_of_now);
    console.log(id);
    main_cart.set(id, selected_product);
    selected_product = null;
    $('.ui.modal.transition.add-to-cart-modal.longer').modal('hide');
    console.log(main_cart);
    updateCartCount();
}); 

$('#add-to-cart-modal-instruction').on('change', function(){ 
    selected_product.instruction = $(this).val();
});

$('input[name=add-to-cart-dinein-takeout]').change(function () { 
    selected_product.order_type = $(this).val();
});

setInterval(() => {
    updateClock();
}, 1000);

function displayName(){
    $('#employee_name').text(
        getStorage('name')
    );
}

//==============initial
function setSelectedItem(item){
    selected_product = {
        item: item,
        ordered_qty: null,
        sub_total: 0,
        additional_cost: 0,
        net_amount: 0,
        order_type : null,
        instruction : null,
        components : []
    };
}

function selectedItemCostComputation(){ 

    selected_product.additional_cost = 0;
    $.each(selected_product.components, function(k,v){
        $.each(v.selectable_items, function(kk,vv){
            if(vv.qty > 0){
                selected_product.additional_cost += (vv.qty * vv.price);
            }
        });
    });

    selected_product.sub_total      = selected_product.item.srp * selected_product.ordered_qty;
    selected_product.net_amount     = selected_product.sub_total + selected_product.additional_cost;
}

function atcmDisplayUpdate(){ // add to cart display update
   console.log( selected_product );

    selectedItemCostComputation();

    //parent qty
    var parent_qty = $('#add-to-cart-modal-txt-qty');
    parent_qty.val( selected_product.ordered_qty );

    // parent components qty
    $.each(selected_product.components, function(k,v){
        $('#pc-' + v.item.product_id).text(
            '' + v.item.description + ' ( ' + selected_product.components[k].item.quantity + ' )'
        );

        $.each(v.selectable_items, function(kk,vv){
            $('#atc-pc'+v.item.product_id+'-spc'+vv.product_id).text('('+vv.qty+ ')');
        });
    });

    // net total
    var net_total = $('#add-to-cart-modal-total');
    net_total.text( numberWithCommas((selected_product.net_amount).toFixed(2)) );
}

function btnSpcMinus(){
    $('.btn-spc-minus').on('click', function(){
        var pc_id       = $(this).data('pc-id');
        var spc_index   = $(this).data('spc-index'); 
        $.each(selected_product.components, function(k,v){

            if(v.item.product_id == pc_id){ 
                if(v.selectable_items[spc_index].qty > 0){
                    selected_product.components[k].item.quantity ++; 
                    selected_product.components[k].selectable_items[spc_index].qty --; 
                } 
            } 
            
        });
        atcmDisplayUpdate();
    });
}

function btnSpcPlus(){
    $('.btn-spc-plus').on('click', function(){
        var pc_id       = $(this).data('pc-id');
        var spc_index   = $(this).data('spc-index'); 
        $.each(selected_product.components, function(k,v){

            if(v.item.product_id == pc_id){
                if(v.item.quantity > 0){
                    selected_product.components[k].item.quantity --; 
                    selected_product.components[k].selectable_items[spc_index].qty ++;
                }
            } 
            
        });
        atcmDisplayUpdate();
    });
}

