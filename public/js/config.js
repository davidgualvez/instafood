"use strict";

$(document).ready(function(){

    //
    $('.ui.dropdown').dropdown();

    // $('#mBtnMenu').on('click',function(){
    //     $('#mMenu').sidebar('toggle');
    // });

    $('.login').on('click',function(){
        redirectTo('/login');
    });  

    // $('.main.menu').visibility({
    //     type: 'fixed'
    //   });
    
    btnLogin();  
    btnLogout(); 


    if( getStorage('token') != null || getStorage('token') != '' ){
        console.log(showStoreOutletName()); 
        $('#outlet-name').text( showStoreOutletName() );

        $('.menunav-customer-registration').on('click', function(){
            console.log('customer registration btn...');
            $('.ui.modal.transition.modal-customer-registration.longer').modal({
                transition: 'horizontal flip',
                inverted: true,
                closable : true, 
                centered: false,
                onHide: function(){
                    console.log('hidden'); 
                    $('.ui.sidebar').sidebar('toggle');
                },
                onShow: function(){
                    console.log('shown');
                },
                onApprove: function() {
                    console.log('Approve');
                    // return validateModal()
                }
            }).modal('show'); 
        }); 

        btnCustomerRegister();

        btnSideMenu();

        //initialize cart
        main_cart = new Map();
        showCart();
    }
}); 

//global variable for all page  
var api = '';
var routes = {
    login:              '/login',
    product: {
        list :          '/products',
        groups :        '/products/group',
    },
    customer : {
        create :        '/costumer'
    }
};
let main_cart;

//
// Requests GET | POST 
//
function post(url, request, callback) {
    $.ajax({
        url: api + url,
        type: "POST",
        dataType: "json",
        data: request,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (data) {
            callback(data);
        },
        error: function (data) {
            console.log(data);
            showError('Server error', 'Please ask the system administrator about this!', function () {

            });
        }
    });
}

function postWithHeader(url, request, callback) {
    var token = localStorage.getItem('token');
    $.ajax({
        url: api + url,
        type: "POST",
        dataType: "json",
        data: request,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            token: token
        },
        success: function (data) {
            callback(data);
        },
        error: function (data) {
            showError('Server error', 'Please ask the system administrator about this!', function () {

            });
        }
    });
}

function get(url, request, callback) {
    $.ajax({
        url: api + url,
        type: "GET",
        dataType: "json",
        data: request,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (data) {
            callback(data);
        },
        error: function (data) {
            showError('Server error', 'Please ask the system administrator about this!', function () {

            });
        }
    });
}

//
// Authentication Handler
//
function isLogin() {
    var token = localStorage.getItem('token');
    if (token == '' || token == null) {
        return false; //says that the use is not loggedin
    }
    return true; // says that the user is current loggedin 
}

function logout() {
   clearStorage();
    window.location.href = "/login";
}

// local storage
function setStorage(key, value){
    localStorage.setItem(key, value);
}

function getStorage(key){
    return localStorage.getItem(key);
}

function clearStorage() {
    localStorage.clear();
}

function redirectTo(link) {
    window.location.href = link;
}

function showInfo(title, message, callback) {
    iziToast.info({
        title: title,
        message: message,
        position: 'topRight',
        // backgroundColor: 'rgba(129,212,250, 1)',
        onClosed: function () {
            callback();
        },
        displayMode : 'replace'
    });
}

function showSuccess(title, message, callback) {
    
    iziToast.success({
        title: title,
        message: message,
        position: 'topRight',
        onClosed: function () {
            callback();
        },
        displayMode : 'replace'
    });

}

function showWarning(title, message, callback) {
    iziToast.warning({
        title: title,
        message: message,
        position: 'topRight',
        onClosed: function () {
            callback();
        },
        displayMode : 'replace'
    });
}

function showError(title, message, callback) {
    iziToast.error({
        title: title,
        message: message,
        position: 'topRight',
        onClosed: function () {
            callback();
        },
        displayMode : 'replace'
    });
}

function getParams(id) {
    var urlParams = new URLSearchParams(window.location.search);
    var x = urlParams.get(id); //getting the value from url parameter
    return x;
}

function validateEmail(email) {
    var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(String(email).toLowerCase());
}

function validateContactNumber(value) {
    //var regEx = /^([ 0-9\(\)\+\-]{8,})*$/; // accept any phone or mobile number
    var regEx = /^(09|\+639)\d{9}$/; // accept only PH Mobile number 
    if (!value.match(regEx)) {
        return false;
    }
    return true;
}

function btnLogin(){
    $('#btn-login').on('click',function(){
        window.location.href = '/login';
    });
}

function btnLogout() {
    $('.btn-signout').on('click', function () {
        console.log('btn-signout clicked...');
        logout();
    });
}

//global app functionalities
function showCart(){
    $('#btn-carts-qty').on('click', function(){
        console.log('showing carts...');
        var cart = $('.ui.modal.cart-modal');
        cart.modal({
            transition: 'fade up', 
            inverted: true,
            closable: true,
            onHide: function () {
                console.log('hidden');
                updateCartCount();
            },
            onShow: function () {
                console.log('shown');
            },
            onApprove: function () {
                console.log('Approve');
                updateCartCount();
                // return validateModal()
            }
        }).modal('show');  
        updateCart();
    }); 
}

function removeItemFromCart(){
    $('.remove-item-from-cart').on('click', function(){
        console.log(this);
        main_cart.delete( $(this).data('id') );

        updateCart();
    });
}

function updateCartCount(){  
    var qty = 0;
    for (let item of main_cart.values()) { // the same as of recipeMap.entries()
        console.log(item);
        qty = qty + item.ordered_qty;
    }
    $('#btn-carts-qty').html(
        '<i class="cart icon"></i> ' + qty
    );
}

function updateCart(){
    //display item on cart
        console.log(main_cart);
        var mc_list_container = $('.ui.divided.animated.list.mc-list');
        mc_list_container.empty();
        var sub_total   = 0;
        var total       = 0;
        main_cart.forEach((value, key, map) => {
            console.log(key,value); // cucumber: 500 etc

            var item_srp = value.item.srp;
            var item_ordered_qty = value.ordered_qty;
            var item_total  = item_srp * item_ordered_qty;

            var others = '';


            if ( value.instruction != null) {  
                others += '<div class="item">' + value.instruction + '</div>';
            }

            mc_list_container.append(
                '<div class="item">'+
                    '<div class="right floated content">' +
                        '<span>PHP ' + numberWithCommas(item_total.toFixed(2))+'</span>&nbsp;'+
                        '<a data-id="'+key+'" class="remove-item-from-cart">'+
                            '<i class="large red remove link icon"></i>'+
                        '</a>'+
                    '</div>'+
                    '<span class="ui avatar image " style="width:25px;">' + item_ordered_qty+'x</span>'+
                    '<div class="content">'+
                        '<a class="header">' + value.item.description+'</a>'+
                        '<div class="description" style="padding:0px!important;">'+
                            '<div class="ui list">'+
                                others +
                            '</div>'+
                        '</div>'+
                    '</div>'+
                '</div>' 
            );

            sub_total += item_total;
        });
        // show sub total
        $('#mc-subtotal').text(numberWithCommas(sub_total.toFixed(2)));
        // show and applying deductions
        total = sub_total;
        $('#mc-total').text( numberWithCommas(total.toFixed(2)));
        removeItemFromCart();

        if(main_cart.size == 0){
            mc_list_container.append('<h1 style="text-align: center;">EMPTY</h1>');
        }
}

function showStoreOutletName(){
    return getStorage('outlet_name');
}

function text_truncate(str, length, ending) {
    if (length == null) {
      length = 100;
    }
    if (ending == null) {
      ending = '...';
    }
    if (str.length > length) {
      return str.substring(0, length - ending.length) + ending;
    } else {
      return str;
    }
};

function FormatNumberLength(num, length) {
    var r = "" + num;
    while (r.length < length) {
        r = "0" + r;
    }
    return r;
}

function getBase64Image(img) {
    // Create an empty canvas element
    var canvas = document.createElement("canvas");
    canvas.width = img.width;
    canvas.height = img.height;

    // Copy the image contents to the canvas
    var ctx = canvas.getContext("2d");
    ctx.drawImage(img, 0, 0);

    // Get the data-URL formatted image
    // Firefox supports PNG and JPEG. You could check img.src to
    // guess the original format, but be aware the using "image/jpg"
    // will re-encode the image.
    var dataURL = canvas.toDataURL("image/png");

    return dataURL.replace(/^data:image\/(png|jpg);base64,/, "");
}

function updateClock() {
    $('#clock').html(moment().format('D. MMMM h:mm:ss A'));
}

function numberWithCommas(number) {
    var parts = number.toString().split(".");
    parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    return parts.join(".");
}

function btnCustomerRegister(){
    $('#modal-btn-customer-register').on('click', function(){
        console.log('test click');
        var name    = $('#modal-cr-name');
        var bdate   = $('#modal-cr-bdate');
        var mnumber = $('#modal-cr-mobile_number'); 

        if( name.val().trim() == '' || name.val().trim() == null){
            showWarning('','Name is required', function(){

            });
            return;
        }

        if( bdate.val().trim() == '' || bdate.val().trim() == null){
            showWarning('','Birthdate is required', function(){

            });
            return;
        }

        if( bdate.val().trim() == '' || bdate.val().trim() == null){
            showWarning('','Birthdate is required', function(){

            });
            return;
        }

        if( mnumber.val().trim() == '' || mnumber.val().trim() == null){
            showWarning('','Mobile number is required', function(){

            });
            return;
        }

        var regEx = /^(9)\d{9}$/; // accept only PH Mobile number  
        if( !mnumber.val().match(regEx) ){
            showWarning('','Invalid Mobile Format', function(){

            });
            return;
        }

        // create new customer for loyalty etc
        var data = {
            name    : name.val(),
            bdate   : bdate.val(),
            mnumber : mnumber.val()
        };

        postWithHeader(routes.customer.create ,data, function(response){
            if( response.success == false){
                showWarning('', response.message, function(){

                });
                return;
            }

            showSuccess('', 'New Customer has been registered', function(){
                
            }); 
            name.val('');
            bdate.val('');
            mnumber.val('');
            $('.ui.modal.transition.modal-customer-registration.longer').modal('hide'); 
            $('.ui.sidebar').sidebar('toggle');
        }); 
    });
}

function btnSideMenu(){
    $('#sidebar-menu').on('click', function(){
        $('.ui.sidebar').sidebar('toggle');
    });
}