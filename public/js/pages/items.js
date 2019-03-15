"use strict";
$(document).ready(function () {
    console.log('loaded...');
    if (!isLogin()) {
        redirectTo('/login');
        return;
    }

    paginateProduct();
    //getItems();
});

//global
let product_lists;
let selected_product;
 
//pagination================================ 
var current_page_product = null; 
var current_data_product = null;

function paginateProduct() {  
    var data = {
        group_id: getStorage('selectedGroup'),
        category_id: getStorage('selectedCategory')
    };

    var url = null;

    if (current_page_product == null) {
        current_page_product = 1;
    }

    //=============
    postWithHeader(
        '/groups/category/items' + "?page=" + current_page_product, 
        data, 
        function (response) {
        
        if (response.success == false) { 
            if (response.status == 401) {
                showWarning('FORBIDDEN', response.message, function () {
                    logout();
                });
                return;
            } 
        } 

        current_page_product = response.result.data.current_page;
        var items = response.result.data.data;
 
        dataDisplayerProduct(items, response.result.data.from); 
        if (response.result.data.next_page_url != null) {
            current_page_product++;
            paginateProduct();
            console.log(items);
        } else { 
            console.log(items); 
            // btnAddToCart();
            console.log(product_lists);
            btnAddToCart();
        }
    });
    //============= 
} 

function dataDisplayerProduct(data, from) {
    var items = $('#products_container');

    if (current_page_product == 1) {
        items.empty();
    }

    if (from == null) {
        $('#current_page_product').html('Nothing to display...');
        showWarning('', 'No Result...', function () {
        });
        return;
    }

    if (from == 1) {
        product_lists = new Map();
    }

    current_data_product = data;
    $.each(data, function (key, value) {
        var category = value.group_name;
        items.append(
            '<div class="item product" data-id="' + from + '" >' +
            '<div class="right floated content">' +
            '<a class="ui violet tag label right floated">₱ ' + value.srp + '</a>' +
            '</div>' +
            // '<strong>'+ (from) +'</strong>&nbsp; '+
            // '<img class="ui avatar image" src="https://semantic-ui.com/images/avatar/small/daniel.jpg">'+
            '<div class="content" >' +
            '<a class="header">' + value.description + '</a>' +
            '</div>' +
            '</div>'
        );

        product_lists.set(from, value);
        from++;
    });

}
//end of pagination================

function btnAddToCart(){
    $('.product').on('click', function () {
        let id = $(this).data('id');
        let item = product_lists.get(id); 
        
        setStorage('selectedItem', JSON.stringify(item));
        redirectTo('/groups/category/items/item');
    });
}

function getItems() {
    var data = {
        group_id: getStorage('selectedGroup'),
        category_id: getStorage('selectedCategory')
    };

    postWithHeader('/groups/category/items', data, function (response) {
        console.log(response);
    });
}
