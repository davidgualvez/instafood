@extends('layouts.main')

@section('title', 'Category')

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
        postWithHeader(routes.product.groups, {}, function (response) {
             var cat = $('.ui.grid.categories');
             cat.empty(); 
             var ctr = 1;
             var strHtml = '';
             var baseCtr = 1;
            $.each(response.data, function (key, val) {
                //populate the categories from this response 
                console.log(key,val, ctr,baseCtr);
                if(ctr == 1){
                    strHtml += '<div class="doubling four column row">';
                } 
                
                strHtml +=  '<div class="column">';
                    strHtml += '<button class="massive ui button fluid btn-group" data-group-id="'+val.group_id+'"> '+val.description+' </button>';
                strHtml += '</div>';
                
                if(ctr == 4 ||  baseCtr == Object.keys(response.data).length ){
                    strHtml += '</div>';
                    ctr = 0;
                }
                ctr++;
                baseCtr++;
            });
            console.log(strHtml);
            cat.html(strHtml);
            btnGroupOnClick();
        });
    }
    
    function btnGroupOnClick(){
        $('.btn-group').on('click', function(){  
            setStorage('selectecGroup', $(this).data('group-id'));
            redirectTo('/groups/category');
        });
    }
    
</script>
@endsection

@section('content')   
<br> <br>
<div class="ui container" style="margin-top: 5px;">
    <div class="ui breadcrumb">  
        <div class="active section">Category</div>  
    </div>    
</div>

<div class="ui stackable grid container" style="margin:5px;">
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