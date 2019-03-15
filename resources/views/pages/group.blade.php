@extends('layouts.main')

@section('title', 'Category')

@section('custome_css')
    
@endsection

@section('custom_js') 
<script src="/js/pages/group.js"></script>
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