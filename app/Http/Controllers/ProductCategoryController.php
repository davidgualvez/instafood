<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Category;

class ProductCategoryController extends Controller
{
    //
    public function getByGroupCode($group_code){

        $result = Category::getByGroupId($group_code);

        $result->transform( function($v){
            return [
                'category_id'       => $v->category_id,
                'description'       => $v->description
            ];
        });


        return response()->json([
            'success'   => true,
            'status'    => 200,
            'result'    => $result
        ]);
    }
}
