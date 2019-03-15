"use strict";
$(document).ready(function () {
    console.log('loaded...');
    if (!isLogin()) {
        redirectTo('/login');
        return;
    }

    $('.ui.accordion').accordion();
    $('.ui.radio.checkbox').checkbox();
    
    loadItem();
});

/**
 * GLOBAL
 */
let  selected_product;

function loadItem(){ 

    var parsedItem = JSON.parse( getStorage('selectedItem') ); 
    setSelectedItem(parsedItem);

    /**
     * Set Title
     */
    $('.item-description').text(parsedItem.description); 
    
    /**
     * Set Item Price
     */ 
    $('.add-to-cart-modal-pprice').text('PHP ' + parsedItem.srp);

    //qty set to 1
    $('#add-to-cart-modal-txt-qty').val(1);
    selected_product.ordered_qty = 1;

    /**
     * Display Dine-in or Take-out
     */
    if (parsedItem.is_food != 1) {
        $('.cart-food-dinein-takeout').hide();
        selected_product.order_type = 'take-out';
    } else {
        $('.cart-food-dinein-takeout').show();
        selected_product.order_type = 'dine-in';
    } 

    /**
     * Display Components
     */
    getComponents(getStorage('outlet_id'), parsedItem.product_id);
  
    //net amount
    $('#add-to-cart-modal-total').text(numberWithCommas((selected_product.net_amount).toFixed(2)));
    atcmDisplayUpdate();

    $('.ui.inverted.dimmer').removeClass('active');
    console.log(selected_product);
}

function setSelectedItem(item) {
    selected_product = {
        item: item,
        ordered_qty: null,
        sub_total: 0,
        additional_cost: 0,
        net_amount: 0,
        order_type: null,
        instruction: null,
        components: []
    };
}

$('#add-to-cart-modal-btn-minus-qty').on('click', function () {
    var txtQty      = $('#add-to-cart-modal-txt-qty');
    var netTotal    = $('#add-to-cart-modal-total');
    if (parseInt(txtQty.val()) > 1) {
        var qty = parseInt(txtQty.val()) - 1;
        selected_product.ordered_qty = qty;
        
        $.each(selected_product.components, function (k, v) { 
            var si_length = Object.keys(v.selectable_items).length;
            var ctr = si_length;
            var tobe_deduct = selected_product.components[k].item.base_quantity * 1;

            for (var i = 0; i < si_length; i++) {
                ctr--;

                // if can deduct
                if (v.selectable_items[ctr].qty > 0) { 
                    if (tobe_deduct > selected_product.components[k].selectable_items[ctr].qty) {
                        tobe_deduct = tobe_deduct - selected_product.components[k].selectable_items[ctr].qty;
                        selected_product.components[k].selectable_items[ctr].qty = 0;
                    } else {
                        selected_product.components[k].selectable_items[ctr].qty = selected_product.components[k].selectable_items[ctr].qty - tobe_deduct;
                        tobe_deduct = 0;
                        i = si_length;
                    } 
                }

            }
 
            if (tobe_deduct > 0) { 
                selected_product.components[k].item.quantity = selected_product.components[k].item.quantity - tobe_deduct; 
            } 
        });
    }
    atcmDisplayUpdate(); 
});

$('#add-to-cart-modal-btn-plus-qty').on('click', function () {
    var txtQty = $('#add-to-cart-modal-txt-qty');
    var netTotal = $('#add-to-cart-modal-total');

    var qty = parseInt(txtQty.val()) + 1;
    selected_product.ordered_qty = qty;

    $.each(selected_product.components, function (k, v) {
        selected_product.components[k].qty += 1;
        selected_product.components[k].item.quantity += selected_product.components[k].item.base_quantity * 1;
    });  

    atcmDisplayUpdate(); 
}); 

function atcmDisplayUpdate() { // add to cart display update 

    selectedItemCostComputation();

    //parent qty
    var parent_qty = $('#add-to-cart-modal-txt-qty');
    parent_qty.val(selected_product.ordered_qty);

    // parent components qty
    $.each(selected_product.components, function (k, v) {
        $('#pc-' + v.item.product_id).text(
            '' + v.item.description + ' ( ' + selected_product.components[k].item.quantity + ' )'
        );

        $.each(v.selectable_items, function (kk, vv) {
            $('#atc-pc' + v.item.product_id + '-spc' + vv.product_id).text('(' + vv.qty + ')');
        });
    });

    // net total
    var net_total = $('#add-to-cart-modal-total');
    net_total.text(numberWithCommas((selected_product.net_amount).toFixed(2)));
}

function selectedItemCostComputation() { 
    selected_product.additional_cost = 0;

    $.each(selected_product.components, function (k, v) {
        $.each(v.selectable_items, function (kk, vv) {
            if (vv.qty > 0) {
                selected_product.additional_cost += (vv.qty * vv.price);
            }
        });
    });

    selected_product.sub_total = selected_product.item.srp * selected_product.ordered_qty;
    selected_product.net_amount = selected_product.sub_total + selected_product.additional_cost;
}

function getComponents(outlet_id = null, product_id = null) {

    var data = {
        outlet_id: outlet_id
    }
    postWithHeader(
        '/product/' + product_id + '/components',
        data,
        function (response) {

            var result = response.data;

            var mlist = $('.add-to-cart-modifiables'); // modifiable list
            mlist.empty();

            if (result.length > 0) {

                $.each(result, function (k, v) {
                    if (v.modifiable == 1 || v.modifiable == '1') {
                        //console.log(v);

                        // add to components in select_product object
                        var item = {
                            item: {
                                parent_id: v.parent_id,
                                product_id: v.product_id,
                                description: v.description,
                                base_quantity: parseInt(v.quantity),
                                product_category: v.product_category,
                                modifiable: v.modifiable,
                                rp: parseFloat(v.rp),
                                quantity: parseInt(v.quantity),
                                parts_type: v.parts_type,
                                kitchen_loc: v.kitchen_loc
                            },
                            qty: selected_product.ordered_qty,
                            selectable_items: []
                        };

                        // create modify content for each item
                        var qty = selected_product.ordered_qty * v.quantity;
                        mlist.append(
                            '<div class="title " style="width: 100%;">' +
                            '<i class="dropdown icon"></i>' +
                            'Click to change' +
                            '<label style="float: right;" id="pc-' + v.product_id + '">' + v.description + ' ( ' + qty + ' )</label>' +
                            '</div>' +

                            '<div class="content"   style="padding:10px;">' +
                            '<div class="ui middle aligned divided list  add-to-cart-selectables" id="m-item-' + v.product_id + '">' +
                            '</div>' +
                            '</div>'
                        );


                        get('/products/group/' + v.product_category, {
                            outlet_id: getStorage('outlet_id')
                        }, function (response) {

                            var selectable_container = $(".add-to-cart-selectables#m-item-" + v.product_id);
                            selectable_container.empty();

                            $.each(response.data, function (kk, vv) {
                                 
                                // if (v.product_id != vv.product_id ){
                                     
                                    var rp = 0;
                                    if (parseFloat(vv.srp) > parseFloat(v.rp)) {
                                        rp = parseFloat(vv.srp) - parseFloat(v.rp);
                                    }

                                    item.selectable_items.push({
                                        category_id: vv.category_id,
                                        description: vv.description,
                                        short_code: vv.short_code,
                                        is_food: vv.is_food,
                                        is_postmix: vv.is_postmix,
                                        outlet_id: vv.outlet_id,
                                        product_id: vv.product_id,
                                        price: rp,
                                        qty: 0,
                                        parts_type: vv.parts_type,
                                        kitchen_loc: vv.kitchen_loc
                                    });

                                    var id = v.product_id + '-' + kk;

                                    selectable_container.append(
                                        '<div class="item">' +
                                        '<div class="right floated content"> ' +
                                        '<strong id="atc-pc' + v.product_id + '-spc' + vv.product_id + '">(0)</strong> &nbsp;' +
                                        '<div data-pc-id="' + v.product_id + '" data-spc-index="' + kk + '" id="' + id + '" class="btn-spc-minus ui green button">' +
                                        '<i class="minus icon"></i>' +
                                        '</div>' +
                                        '<div data-pc-id="' + v.product_id + '" data-spc-index="' + kk + '" id="' + id + '" class="btn-spc-plus ui red button">' +
                                        '<i class="plus icon"></i>' +
                                        '</div>' +
                                        '</div>' +
                                        '<div class="content">' +
                                        vv.short_code + ' ( ₱ ' + numberWithCommas((rp).toFixed(2)) + ' )' +
                                        '</div>' +
                                        '</div>'
                                    );
                                    
                                    btnSpcMinus(id);
                                    btnSpcPlus(id);
                                
                                // } 
                                
                            });  
                             
                        });
                        // display selectables
                        selected_product.components.push(item); 
                    } 
                });

                
            }

        });
}

function btnSpcMinus(id) {
    $('#'+id+'.btn-spc-minus.ui.green.button').on('click', function () {
        console.log($(this));
        var pc_id = $(this).data('pc-id');
        var spc_index = $(this).data('spc-index');
        $.each(selected_product.components, function (k, v) {

            if (v.item.product_id == pc_id) {
                if (v.selectable_items[spc_index].qty > 0) {
                    selected_product.components[k].item.quantity++;
                    selected_product.components[k].selectable_items[spc_index].qty--;
                }
            }

        });
        atcmDisplayUpdate();
    });
}

function btnSpcPlus(id) {
    $('#'+id+'.btn-spc-plus.ui.red.button').on('click', function () { 
        console.log($(this));
        var pc_id = $(this).data('pc-id');
        var spc_index = $(this).data('spc-index');
        $.each(selected_product.components, function (k, v) {

            if (v.item.product_id == pc_id) {
                if (v.item.quantity > 0) {
                    selected_product.components[k].item.quantity--;
                    selected_product.components[k].selectable_items[spc_index].qty++;
                }
            }

        });
        atcmDisplayUpdate();
    });
}

$('#add-to-cart-modal-btn').on('click', function(){
    console.log('...', selected_product);
    //redirectTo('');
    // showSuccess(selected_product.item.description, ' has been added.' , function(){
    //     redirectTo('');
    // });
    // $.confirm({
    //     title: 'Confirm!',
    //     content: 'Simple confirm!',
    //     confirm: function () {
    //         $.alert('Confirmed!');
    //     },
    //     cancel: function () {
    //         $.alert('Canceled!')
    //     }
    // });
});