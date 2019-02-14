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

    current_data_product = data;
    $.each(data, function (key, value) {
        var category = value.group_name;
        items.append(
            '<div class="card">'+
                '<div class="image">'+
                    '<img class="product_image add-to-cart" '+
                    'src="https://chap.website/wp-content/uploads/2017/01/pexels-photo-300x300.jpg" '+
                    'data-product-id="' + value.product_id + '"' +
                    'data-outlet-id="' + value.outlet_id + '"' +
                    'data-description="' + value.description + '"' +
                    'data-srp="' + value.srp + '"' +
                    'data-image="' + value.image + '"' +
                    '>'+
                '</div>'+
                    '<div class="content">'+
                        '<div class="header">' + value.description+'</div>' +
                        '<div class="meta">' +
                    '</div>'+
                        //'<div class="description">TEST</div>'+
                   '</div>'+
                    '<div class="extra content">'+

                        '<div class="ui small header">'+
                            '<span class=" ">'+
                                '<span class=" ">'+
                                    'Php'+
                                    '</span>'+
                                    value.srp +
                                '</span>'+
                        '</div>'+ 
                    '</div>'+
                    '<div class="ui violet bottom attached button add-to-cart" '+
                        'id="p'+value.product_id+'-o'+value.outlet_id+'" '+
                        'data-product-id="'+value.product_id+'"' +
                        'data-outlet-id="'+value.outlet_id+'"' +
                        'data-description="'+value.description+'"' +
                        'data-srp="'+value.srp+'"' +
                        'data-image="'+value.image+'"' +
                        '>'+
                            '<i class="add icon"></i>'+
                            'Add to Cart'+
                    '</div>'+
                '</div>'
        );
        from++;
        //btnProductAddToCart(value.id);
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
    $('.add-to-cart').on('click', function(){
        console.log('test click...');
        $('.ui.dimmer.add-to-cart-modal').dimmer('toggle'); 


        //qty set to 1
        $('#add-to-cart-modal-txt-qty').val(1);
        //name
        $('#add-to-cart-modal-pname').text($(this).data('description'));
        //price
        $('#add-to-cart-modal-pprice').text('PHP '+$(this).data('srp'));

    });
}

// function addToCartModalClose(){
    $('#add-to-cart-modal-close').on('click', function(){
        console.log('modal close click...');
        $('.ui.dimmer.add-to-cart-modal').dimmer('hide');
    });
// }

// function addToCartModalBtnPlus(){
    $('#add-to-cart-modal-btn-plus-qty').on('click', function(){
        var txtQty = $('#add-to-cart-modal-txt-qty');
         
        var qty     = parseInt(txtQty.val()) + 1;
        
        txtQty.val(qty);


        console.log('plus clicked...');
    });
// }

// function addToCartModalBtnMinus() {
    $('#add-to-cart-modal-btn-minus-qty').on('click', function () {
        var txtQty = $('#add-to-cart-modal-txt-qty');

        if (parseInt(txtQty.val()) > 1 ){
            var qty = parseInt(txtQty.val()) - 1; 
            txtQty.val(qty);
        }
        
        console.log('minus clicked...');
    });
// }

// function addToCartModalBtn() {
    $('#add-to-cart-modal-btn').on('click', function () {
        console.log('modal finish click...');
        $('.ui.dimmer.add-to-cart-modal').dimmer('hide');
    });
// }

setInterval(() => {
    updateClock();
}, 1000);

function displayName(){
    $('#employee_name').text(
        getStorage('name')
    );
}