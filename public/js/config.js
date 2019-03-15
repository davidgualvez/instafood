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
                transition: 'fade up',
                inverted: true,
                closable : true, 
                centered: false,
                onHide: function(){
                    console.log('hidden');  
                },
                onShow: function(){
                    console.log('shown');
                    $('.ui.sidebar').sidebar('toggle');
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
        // main_cart_other =  {
        //     headcounts : {
        //         regular : 0,
        //         sc_pwd  : 0
        //     }
        // };

        showCart();
        btnNext1HcRegularMinus();
        btnNext1HcRegularPlus();
        btnNext1HcScpwdMinus();
        btnNext1HcScpwdPlus();
    }
}); 

//global variable for all page  
var api = '';
var local_printer_api = "http://instafood-printer.dsc:8082/api";
var routes = {
    login:              '/login',
    product: {
        list :          '/products',
        groups :        '/products/group',
        category :      '/products/group/category' // + id
    },
    customer : {
        create :        '/costumer'
    }
};
let main_cart;
var main_cart_other;

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
            console.log(data);
            callback(data);
        },
        error: function (data) {
            console.log(data, data.status);
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

function customPost(url, request, callback) {
    $.ajax({
        url: url,
        type: "POST",
        dataType: "json",
        data: request,
        headers: {
            //'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
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

function cl(arr = arr() ){
    arr.forEach(element => {
        console.log(element);
    });
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
        
        // if( getStorage('order_slip') == 'null'){
        //     showWarning('','No item to be display.', function(){

        //     });
        //     return;
        // }



        var cart = $('.ui.modal.cart-modal');
        cart.modal({
            transition: 'fade up', 
            inverted: true,
            closable: true,
            centered: false,
            allowMultiple: true,
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
        main_cart_other = {
            headcounts: {
                regular: 1,
                sc_pwd: 0,
            },
            customer_name : null,
            mobile_number: null
        };
    }); 
}

// function showCartProceed(){
    $('#mc-btn-proceed').on('click', function(){
        console.log('test proceed...');

       // $('.ui.modal.cart-modal').modal('hide');
        $('.ui.modal.cart-modal-next1').modal({
            transition: 'fade up',
            // inverted: true,
            closable: true,
            // centered: false, 
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
            }
        }).modal('show');

        // var proceedToNextCart = $('.ui.modal.cart-modal-next1');
        // proceedToNextCart.modal({
        //     transition: 'fade up',
        //     inverted: true,
        //     closable: true,
        //     centered: false,
        //     onHide: function () {
        //         console.log('hidden'); 
        //     },
        //     onShow: function () {
        //         console.log('shown');
        //     },
        //     onApprove: function () {
        //         console.log('Approve');
        //     }
        // }).modal('show');

        updateCartNext1();
        $('#mc-next1-txt-mnum').val('');
        $('#mc-next1-customer-result').empty();
        
    });
// }

function updateCartNext1(){
    var hc_regular  = $('#cart-modal-next1-hc-regular');
    // var hc_scpwd    = $('#cart-modal-next1-hc-cspwd');
    console.log(main_cart_other.headcounts.regular);
    hc_regular.val( main_cart_other.headcounts.regular);
    // hc_scpwd.val( main_cart_other.headcounts.sc_pwd);

    //console.log( hc_regular, hc_scpwd); 
}

function btnNext1HcRegularMinus(){
    $('#cart-modal-next1-hc-regular-btn-minus').on('click', function(){
        console.log('test....1');
        if (main_cart_other.headcounts.regular > 1 ){
            main_cart_other.headcounts.regular --;
        }

        updateCartNext1();
    });
}

function btnNext1HcRegularPlus() {
    $('#cart-modal-next1-hc-regular-btn-plus').on('click', function () {
        console.log('test....2'); 
        main_cart_other.headcounts.regular++; 
        updateCartNext1();
    });
}

function btnNext1HcScpwdMinus() {
    $('#cart-modal-next1-hc-scpwd-btn-minus').on('click', function () {
        console.log('test....3');
        if (main_cart_other.headcounts.sc_pwd > 0) {
            main_cart_other.headcounts.sc_pwd--;
        }

        updateCartNext1();
    });
}

function btnNext1HcScpwdPlus() {
    $('#cart-modal-next1-hc-scpwd-btn-plus').on('click', function () {
        console.log('test....4');
        main_cart_other.headcounts.sc_pwd++;
        updateCartNext1();
    });
}

$('#mc-next1-mnum-btn-search').on('click', function(){
    console.log('test click...');
    var mnum = $('#mc-next1-txt-mnum');
    if(mnum.val() == null || mnum.val() == ''){
        showWarning('', 'Mobile number is requred!', function(){

        });
        return;
    }

    var data = {
        search_by   : 'mobile number',
        data        : {
            mobile_number : mnum.val()
        }
    };

    $('#mc-next1-mnum-btn-search').addClass('loading');
    postWithHeader('/customer/search', data, function(response){
        $('#mc-next1-mnum-btn-search').removeClass('loading');

        var output = $('#mc-next1-customer-result');
        if(response.success == false){
            output.html('<a class="ui yellow label">'+response.message+'</a>');
            main_cart_other.mobile_number = null;
            return;
        }

        var name = response.data.NAME;
        var points = parseFloat(response.data.POINTS).toFixed(2);
        var wallet = parseFloat(response.data.WALLET).toFixed(2);
        output.html(
            '<div class="ui list">'+
                '<div class="item">'+
                    '<strong>Name:</strong> '+ name+
                '</div>'+
                '<div class="item">'+
                    '<strong>Points:</strong> '+ numberWithCommas(points)+
                '</div>'+
                '<div class="item">'+
                    '<strong>Wallet:</strong> '+ numberWithCommas(wallet)+
                '</div>'+
            '</div>'
        );
        main_cart_other.mobile_number = response.data.MOBILE_NUMBER; 
        main_cart_other.customer_name = response.data.NAME;
    });

});

$('#mc-next1-btn-finish').on('click', function(){
    
    var items=[];
    for (let item of main_cart.values()) {
        items.push(item);
    }

    var data = {
        items : items,
        others: main_cart_other
    };
 
    postWithHeader('/sales-order', data, function(response){
        if( response.success == false){
            showWarning('', response.message, function(){

            });
            return;
        }

        //printOS(data, response.data);
        var final_data = {
            os_number: response.data.orderslip_id,
            server_name: getStorage('name'),
            created_at: response.data.created_at,
            data : data
        };
        customPost(local_printer_api + '/print/sales-order', final_data, function(response){
            console.log(response);
        });

        var proceedToNextCart = $('.ui.modal.cart-modal-next1');
        proceedToNextCart.modal('hide');
        main_cart.clear();
        updateCart();
        updateCartCount();

    });

});

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
            var item_total  = (item_srp * item_ordered_qty);

            var others = '';

            $.each(value.components, function (k, v) {
                console.log('...: ' + v.item.quantity);
                if(v.item.quantity > 0){ 
                    others += '<div class="item"> + '+ v.item.quantity + ' x ' + v.item.description + ' (PHP 0.00)</div>'; 
                }

                $.each(v.selectable_items, function (kk, vv) {
                    if(vv.qty > 0){
                        var amount = vv.qty * vv.price;
                        others += '<div class="item"> + ' + vv.qty + ' x ' + vv.short_code + ' (PHP '+ numberWithCommas(amount.toFixed(2)) +')</div>';
                    }
                });

            });

            if ( value.instruction != null) {  
                others += '<div class="item"> + ' + value.instruction + '</div>';
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

            sub_total += (item_total)  + value.additional_cost;
        });
        // show sub total
        $('#mc-subtotal').text(numberWithCommas(sub_total.toFixed(2)));
        // show and applying deductions
        total = sub_total;
        $('#mc-total').text( numberWithCommas(total.toFixed(2)));
        removeItemFromCart();

        if(main_cart.size == 0){
            mc_list_container.append('<h1 style="text-align: center;">EMPTY</h1>');
        
            $('#mc-btn-proceed').attr('disabled','disabled');
            return;
        }else{
            $('#mc-btn-proceed').removeAttr('disabled','disabled');
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

function printOS(data, response_data){
    console.log(data, response_data, response_data.orderslip_id); 

    var customer_information = null;
    if (data.others.mobile_number != null){
        customer_information = [
            {
                columns: [
                    {
                        text: 'Customer Information'
                    }
                ],
                style: 'cust_info_header'
            },
            {
                columns: [
                    {
                        text: 'Name \t\t : ' + data.others.customer_name
                    }
                ],
                style: 'cust_info_detail'
            },
            {
                columns: [
                    {
                        text: 'Mobile No. : +63-' + data.others.mobile_number
                    }
                ],
                style: 'cust_info_detail',
                margin: [15, 0, 0, 15],
            }
        ];
    }

    var items = [];
    $.each(data.items, function(k,v){

        var price   = parseFloat(v.item.srp);
        var qty     = v.ordered_qty;
        var amount  = (qty * price).toFixed(2);

        var data = {
            columns: [
                {
                    text: v.ordered_qty+'x',
                    margin: [5, 0, 0, 0],
                    width: 25,
                },
                {
                    text: v.item.description,
                    margin: [0, 0, 0, 0],
                    width: 125,
                },
                {
                    text: 'Php ' + numberWithCommas(amount),
                    alignment: 'right',
                    width: 70,
                    margin: [0, 0, 10, 0],
                }
            ],
            fontSize: '8',
            margin: [0, 2, 0, 0],
        };  
        items.push(data);
        //=============================================================

        $.each( v.components, function(kk,vv) {
            console.log(vv);
            if (vv.item.quantity > 0){
                var price   = parseFloat(vv.item.rp);
                var qty     = vv.item.quantity;
                var amount  = (0).toFixed(2);
                
                var data = {
                    columns: [
                        {
                            text: '',
                            margin: [5, 0, 0, 0],
                            width: 25,
                        },
                        {
                            text: '+ (' +qty + ') ' + vv.item.description,
                            margin: [0, 0, 0, 0],
                            width: 125,
                        },
                        {
                            text: 'Php ' + numberWithCommas(amount),
                            alignment: 'right',
                            width: 70,
                            margin: [0, 0, 10, 0],
                        }
                    ],
                    fontSize: '8',
                    margin: [0, 2, 0, 0],
                };
                items.push(data); 
            }

            //=============================================================
            $.each(vv.selectable_items, function (kkk, vvv) {
                if (vvv.qty > 0) {
                    var price = parseFloat(vvv.price);
                    var qty = vvv.qty;
                    var amount = (qty * price).toFixed(2);
                    var data = {
                        columns: [
                            {
                                text: '',
                                margin: [5, 0, 0, 0],
                                width: 25,
                            },
                            {
                                text: '+ (' + qty + ') ' + vvv.short_code,
                                margin: [0, 0, 0, 0],
                                width: 125,
                            },
                            {
                                text: 'Php ' + numberWithCommas(amount),
                                alignment: 'right',
                                width: 70,
                                margin: [0, 0, 10, 0],
                            }
                        ],
                        fontSize: '8',
                        margin: [0, 2, 0, 0],
                    };
                    items.push(data);
                }
            });

        });
        //=============================================================
        
        // appending intruction
        if( v.instruction != null){
            var data = {
                columns: [
                    {
                        text: '',
                        margin: [5, 0, 0, 0],
                        width: 25,
                    },
                    {
                        text: '+ '+v.instruction,
                        margin: [0, 0, 0, 0],
                        width: 125,
                    },
                    {
                        text: '',
                        alignment: 'right',
                        width: 70,
                        margin: [0, 0, 10, 0],
                    }
                ],
                fontSize: '8',
                margin: [0, 2, 0, 0],
            };
            items.push(data);
        }

    });
    console.log(items);

    var docDefinition = {
        content: [
            {
                columns: [
                    {
                        text: 'Enchanted Kingdom',
                    }
                ],
                style: 'header'
            },

            {
                columns: [
                    { 
                        qr: '' + response_data.orderslip_id
                    }
                ],
                style: 'qrcode',
            },

            {
                columns: [
                    {
                        text: 'Order Slip No: ' + response_data.orderslip_id
                    }
                ],
                style: 'os_no'
            },

            customer_information,

            // {
            //     columns: [
            //         {
            //             text: 'Type: ' + data.items.order_type
            //         }
            //     ],
            //     style: 'cust_info_header'
            // },

            items
        ],
        styles: {
            /**
             * HEADER
             */
            header: {
                alignment: 'center',
                margin: [0, 10, 0, 0],
                fontSize: '15',
                bold: true
            },

            /**
             * QR Code
             */
            qrcode: {
                alignment: 'center',
                margin: [0, 15, 0, 0],
            },

            /**
             * OS #
             */
            os_no: {
                alignment: 'center',
                margin: [0, 10, 0, 15],
                fontSize: '10',
            },

            /**
             * Customer Info
             */
            cust_info_header: {
                alignment: 'left',
                margin: [15, 10, 0, 0],
                fontSize: '9',
                bold: true
            },
            cust_info_detail: {
                alignment: 'left',
                margin: [15, 0, 0, 0],
                fontSize: '8'
            }


        },

        //pageSize: 'A5',
        pageSize: { width: 220, height: 'auto' },
        // [left, top, right, bottom] or [horizontal, vertical] or just a number for equal margins
        pageMargins: [2, 0, 0, 15],
    };

    // if (v == 'preview') {
        //pdfMake.createPdf(docDefinition).open();
    // }

    // if (v == 'download') {
        pdfMake.createPdf(docDefinition).download(
            'Enchanted Kingdom OR - ' +
            '.pdf'
        );
    // }

}