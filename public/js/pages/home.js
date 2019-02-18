"use strict";

$(document).ready(function(){
    console.log('loaded...');

    if(!isLogin()){
        redirectTo('/login');
        return;
    } 

    btnSideMenu(); 
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

            $('.ui.sticky').sticky({
                context: '#example1'
            });

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

        console.log(response);

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

function btnSideMenu(){
    $('#sidebar-menu').on('click', function(){
        $('.ui.sidebar').sidebar('toggle');
    });
}

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
                transition: 'horizontal flip',
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
        console.log('product_id: ' + item.product_id);
        getComponents(getStorage('outlet_id'),item.product_id);

        //qty set to 1
        $('#add-to-cart-modal-txt-qty').val(1);
        selectedItemCostComputation(1);

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
    selectedItemCostComputation(qty);

    txtQty.val(qty); 
    netTotal.text( numberWithCommas( (selected_product.net_amount).toFixed(2) ) );
 
}); 
 
$('#add-to-cart-modal-btn-minus-qty').on('click', function () {
    var txtQty = $('#add-to-cart-modal-txt-qty');
    var netTotal = $('#add-to-cart-modal-total');

    if (parseInt(txtQty.val()) > 1 ){
        var qty = parseInt(txtQty.val()) - 1;  
        selectedItemCostComputation(qty);

        txtQty.val(qty);
        netTotal.text( numberWithCommas( (selected_product.net_amount).toFixed(2) ) );
    }
     
}); 
 
$('#add-to-cart-modal-btn').on('click', function () { 
    console.log(selected_product);
    //$('.ui.modal.transition.add-to-cart-modal.longer').dimmer('hide');
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

function selectedItemCostComputation(qty = 1, addedCost= 0){

    selected_product.ordered_qty    = qty;
    selected_product.sub_total      = selected_product.item.srp * selected_product.ordered_qty;
    selected_product.net_amount     = selected_product.sub_total + selected_product.additional_cost;

}


