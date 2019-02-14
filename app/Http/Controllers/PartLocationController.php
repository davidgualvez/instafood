<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Services\UserServices;
use App\Services\Helper;
use App\Model\User;
use App\Model\PartLocation;

use Carbon\Carbon;

class PartLocationController extends Controller
{
    //
    public function lists(Request $request){
        $now = Carbon::now();
        
        $user = User::where('token', $request->header('token'))
            ->first(); 

        if( is_null($user) ){ 
            return response()->json([
                'success' => false,
                'status' => 401,
                'message' => 'Unauthorized Access'
            ]);
        }
            
        $userServices = new UserServices($user);
        $helper = new Helper; 
 
        $duty = $userServices->isOnDuty($helper->getClarionDate($now));

        if($duty == false){
            return response()->json([
                'success'   => false,
                'status'    => 401,
                'message'   => 'Unauthorized Access'
            ]);
        }
 
        /**
         * GET PRODUCT BELONGS TO OUTLET
         */
        $search     = $request->search;
        $categories = $request->categories; 
        $limit      = 10; 
        
        // dd(
        //     $search,
        //     $categories
        // );

        if( $categories[0] == null || $categories[0] == ''){
            // dd(
            //     '1',
            //     $search,
            //     $categories
            // );
            $pl = PartLocation::where('outlet_id', $duty->outlet)
                ->where('description', 'LIKE', '%' . $search . '%') 
                ->orderBy('product_id', 'desc')
                ->simplePaginate($limit);
        }else{ 
            $pl = PartLocation::where('outlet_id', $duty->outlet)
                ->where('description', 'LIKE', '%' . $search . '%')
                ->whereIn('group_id', $categories)
                ->orderBy('product_id', 'desc')
                ->simplePaginate($limit);
        } 

        $pl->getCollection()->transform(function ($value) { 
            //$url = Storage::url($value->IMAGE);
            return [
                'product_id'    => $value->product_id,
                'outlet_id'     => $value->outlet_id, 
                'description'   => $value->description,
                'srp'           => $value->retail,
                'category_id'   => $value->category,
                'group_id'      => $value->group, 
                'image'         => '', 
            ];
        });

        

        return response()->json([
            'success'   => true,
            'status'    => 200,
            'data'      => $pl
        ]);
    }

    public function groups(Request $request){
        $now = Carbon::now();

        $user = User::where('token', $request->header('token'))
            ->first();

        if (is_null($user)) {
            return response()->json([
                'success' => false,
                'status' => 401,
                'message' => 'Unauthorized Access'
            ]);
        }
        
        $userServices = new UserServices($user);
        $helper = new Helper;

        $outlet = $userServices->isOnDuty($helper->getClarionDate($now));


        /**
         * GET PRODUCT BELONGS TO OUTLET
         */
        $pl = PartLocation::with('group')
                ->where('outlet_id', $outlet->outlet)->get();
        
        $groups = $pl->unique('group')->transform(function ($value) {
            
            return [
                'group_id'      => $value->group_id,
                'description'   => $value->group->description
            ];
        });

        /**
         * GET DISTINCT CATEGORY
         */
        return response()->json([
            'success'   => true,
            'status'    => 200,
            'data'      => $groups
        ]); 
    }
}
