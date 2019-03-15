@extends('layouts.main')

@section('title', 'Item')

@section('custom_css')
<link rel="stylesheet" href="/css/plugins/jquery-confirm.min.css">
@endsection

@section('custom_js') 
<script src="/js/plugins/jquery-confirm.min.js"></script>
<script src="/js/pages/item.js"></script>
@endsection

@section('content')   
<br> <br>
<div class="ui container" style="margin-top: 5px;">
    <div class="ui breadcrumb">  
        <a href="/groups" class="section">Category</a>
        <i class="right chevron icon divider"></i>
        <a href="/groups/category" class="section">Category</a>
        <i class="right arrow icon divider"></i> 
        <a href="/groups/category/items" class="section">Items</a>
        {{-- <i class="right arrow icon divider"></i> 
        <div class="active sectionn"></div>   --}}
    </div>    
</div>

<div class="ui active inverted dimmer">
    <div class="ui text loader">Loading</div>
  </div>
<div class="ui stackable grid container" style="margin:5px;">
    <div class="six wide column"> 
        <h3 class="ui header item-description">
            
        </h3>
        <span class="add-to-cart-modal-pprice" style=""></span> 
        <br><br>
        <div class="ui mini labeled action input" style="margin-bottom: 10px;">
            <label for="amount" class="ui label">Qty</label>
            <input  id="add-to-cart-modal-txt-qty" 
                disabled patter="[0-9]*" 
                inputmode="numeric" 
                step="1" 
                min="0" 
                value="1" 
                type="text"> 

            <button id="add-to-cart-modal-btn-minus-qty" class="ui icon button">
                <i class="minus icon"></i>
            </button>
            <button id="add-to-cart-modal-btn-plus-qty" class="ui icon button">
                <i class="plus icon"></i>
            </button>
        </div>
    </div>
    <div class="ten wide column"> 
        <div class="ui form cart-food-dinein-takeout">
            <div class="inline fields">  
            <div class="field">
                <div class="ui radio checkbox">
                <input type="radio" name="add-to-cart-dinein-takeout" value="dine-in" checked="checked">
                <label>DINE-IN</label>
                </div>
            </div>
            <div class="field">
                <div class="ui radio checkbox">
                <input type="radio" name="add-to-cart-dinein-takeout" value="take-out">
                <label>TAKE-OUT</label>
                </div>
            </div> 
            </div>
        </div> 

        {{-- --}}
        <div class="ui fluid accordion add-to-cart-modifiables">
        </div>

        {{-- ===== --}}
        <div class="ui accordion">
            <div class="title">
                <i class="dropdown icon"></i>
                INSTRUCTIONS(Optional)
            </div>
            <div class="content" style="padding-bottom: 10px;">
                <div class="ui form transition hidden"> 
                    <div class="field"> 
                        <textarea id="add-to-cart-modal-instruction" rows="2" placeholder="anything instruction by the customer can be place here.."></textarea>
                    </div>
                </div>
            </div> 
        </div>

        {{-- ===== --}} 
        <div class="actions">  
            <button id="add-to-cart-modal-btn" class="ui button ">
                <i class="plus icon"></i>
                ADD ITEM
            </button>
             <span>
                TOTAL PHP 
                <strong id="add-to-cart-modal-total">
                    
                </strong> 
            </span>
        </div>
    </div> 
</div>
@endsection