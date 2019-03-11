@extends('layouts.main')

@section('title', 'Sub Category')

@section('custome_css')
    
@endsection

@section('custom_js')
<script>
    "use strict";
    $(document).ready(function(){
        console.log('loaded...');
        if(!isLogin()){
            redirectTo('/login');
            return;
        }

        getCategories();
    });

    function getCategories() { 
        var selectedGroup = getStorage('selectecGroup');
        postWithHeader(routes.product.category + '/' + selectedGroup, {}, function (response) { 

            var cat = $('.ui.grid.categories');
            cat.empty(); 
            var ctr = 1;
            var strHtml = '';
            var baseCtr = 1; 
            console.log(response.result);
            $.each(response.result, function (key, val) {
                //populate the categories from this response 
                console.log(key,val, ctr,baseCtr);
                if(ctr == 1){
                    strHtml += '<div class="doubling four column row">';
                } 
                
                strHtml +=  '<div class="column">';
                    strHtml += '<button class="massive ui button fluid btn-category" data-category-id="'+val.category_id+'"> '+val.description+' </button>';
                strHtml += '</div>';
                
                if(ctr == 4 ||  baseCtr == Object.keys(response.result).length ){
                    strHtml += '</div>';
                    ctr = 0;
                }
                ctr++;
                baseCtr++;
            }); 

            cat.html(strHtml);
            btnCategoryOnClick();
        });

        function btnCategoryOnClick(){
            $('.btn-category').on('click', function(){  
                setStorage('selectecCategory', $(this).data('category-id')); 
            });
        }
    }
</script>
@endsection

@section('content') 
<br> <br>
<div class="ui container" style="margin-top: 5px;">
    <div class="ui breadcrumb"> 
        <a href="/groups" class="section">Category</a>
        <i class="right arrow icon divider"></i>
        <div class="active section">Sub Category</div>  
    </div>
</div>
<div class="ui stackable grid container-fluid" style="margin:5px;">
    <div class="column">  
        <div class="ui grid categories"> 
            {{-- <div class="doubling four column row">
                <div class="black column">
                    <button class="massive ui button fluid"> 1 </button>
                </div>
                <div class="column">
                    <button class="massive ui button fluid"> 2 </button>
                </div>
                <div class="column">
                    <button class="massive ui button fluid"> 3 </button>
                </div>
                <div class="column">
                    <button class="massive ui button fluid"> 4 </button>
                </div> 
            </div>  --}}
        </div>
    </div>
</div>
@endsection