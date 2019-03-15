<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    //
    public function groups(){
        return view('pages.group');
    }

    public function category(){ 
         return view('pages.category');
    }

    public function items(){
        return view('pages.items');
    }

    public function item(){
        return view('pages.item');
    }
}
