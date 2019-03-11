<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    //
    public function groups(){
        return view('pages.home');
    }

    public function category(){ 
         return view('pages.category');
    }
}
