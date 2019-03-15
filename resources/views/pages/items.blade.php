@extends('layouts.main')

@section('title', 'Items')

@section('custome_css')
    
@endsection

@section('custom_js') 
<script src="/js/pages/items.js"></script>
@endsection

@section('content')   
<br> <br>
<div class="ui container" style="margin-top: 5px;">
    <div class="ui breadcrumb">  
        <a href="/groups" class="section">Category</a>
        <i class="right chevron icon divider"></i>
        <a href="/groups/category" class="section">Category</a>
        <i class="right arrow icon divider"></i> 
        <div class="active section">Items</div>  
    </div>    
</div>
<div class="ui stackable grid container" style="margin:5px;">
    <div class="column">
        <div class="ui segment"> 
            <div class="ui middle aligned divided selection list" id="products_container"> 
                
            </div> 
        </div>
    </div>
</div>
@endsection