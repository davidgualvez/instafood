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
    postWithHeader('/groups', {}, function (response) {
        var cat = $('.ui.grid.categories');
        cat.empty();
        var ctr = 1;
        var strHtml = '';
        var baseCtr = 1;
        $.each(response.data, function (key, val) {
            //populate the categories from this response 
            console.log(key, val, ctr, baseCtr);
            if (ctr == 1) {
                strHtml += '<div class="doubling four column row">';
            }

            strHtml += '<div class="column">';
            strHtml += '<button class="massive ui button fluid btn-group" data-group-id="' + val.group_id + '"> ' + val.description + ' </button>';
            strHtml += '</div>';

            if (ctr == 4 || baseCtr == Object.keys(response.data).length) {
                strHtml += '</div>';
                ctr = 0;
            }
            ctr++;
            baseCtr++;
        }); 
        cat.html(strHtml);
        btnGroupOnClick();
    });
}

function btnGroupOnClick() {
    $('.btn-group').on('click', function () {
        setStorage('selectedGroup', $(this).data('group-id'));
        redirectTo('/groups/category');
    });
}