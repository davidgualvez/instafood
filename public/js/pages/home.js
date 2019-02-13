$(document).ready(function(){
    if(!isLogin()){
        redirectTo('/login');
        return;
    }
    
    console.log('loaded...');

    $('.ui.sticky')
    .sticky({
        context: '#example1'
    });

    btnSideMenu();

    btnAddToCart();

    $('.ui.accordion').accordion();
    $('.ui.radio.checkbox').checkbox();

    // addToCartModalClose();
    // addToCartModalBtn();
    // addToCartModalBtnMinus();
    // addToCartModalBtnPlus();

    products(); 
});

function products(){ 
    postWithHeader(routes.product.list, {}, function(response){
        console.log(response);
    });
}

function btnSideMenu(){
    $('#sidebar-menu').on('click', function(){
        $('.ui.sidebar').sidebar('toggle');
    });
}

function btnAddToCart(){
    $('.add-to-cart').on('click', function(){
        console.log('test click...');
        $('.ui.dimmer.add-to-cart-modal').dimmer('toggle');
        
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