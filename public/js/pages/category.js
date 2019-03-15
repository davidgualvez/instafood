"use strict";
$(document).ready(function () {
    console.log('loaded...');
    if (!isLogin()) {
        redirectTo('/login');
        return;
    }

    getCategories();
});

function getCategories() {
    var selectedGroup = getStorage('selectedGroup');
    console.log(selectedGroup);
    postWithHeader(
        '/groups/' + selectedGroup +'/category',
        {}, function (response) {

        var cat = $('.ui.grid.categories');
        cat.empty();
        var ctr = 1;
        var strHtml = '';
        var baseCtr = 1;
        console.log(response.result);
        $.each(response.result, function (key, val) {
            //populate the categories from this response 
            console.log(key, val, ctr, baseCtr);
            if (ctr == 1) {
                strHtml += '<div class="doubling four column row">';
            }

            strHtml += '<div class="column">';
            strHtml += '<button class="massive ui button fluid btn-category" data-category-id="' + val.category_id + '"> ' + val.description + ' </button>';
            strHtml += '</div>';

            if (ctr == 4 || baseCtr == Object.keys(response.result).length) {
                strHtml += '</div>';
                ctr = 0;
            }
            ctr++;
            baseCtr++;
        });

        cat.html(strHtml);
        btnCategoryOnClick();
    }); 
}

function btnCategoryOnClick() {
    $('.btn-category').on('click', function () {
        setStorage('selectedCategory', $(this).data('category-id')); 
        redirectTo('/groups/category/items');
    });
}