<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Services\UserServices;
use App\Services\Helper;
use App\Model\User;
use App\Model\PartLocation;
use App\Model\Postmix;
use App\Model\SitePart;
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
        //dd($search, $categories);
        $val = config('custom.group_not_to_display');
        $val = explode(',',$val);         
         
        if( $categories[0] == null || $categories[0] == ''){ 
            $pl = PartLocation::where('outlet_id', $duty->outlet)
                ->where( 'short_code', 'LIKE', '%'.$search.'%')
                ->where('retail','>',0)
                ->whereNotIn('group_id', $val)
                ->orderBy('product_id', 'desc')
                ->simplePaginate($limit);
        }else{
            $pl = PartLocation::where('outlet_id', $duty->outlet)
                ->where( 'short_code', 'LIKE', '%'.$search.'%')
                ->whereIn('group_id', $categories)
                ->where('retail','>',0)
                ->whereNotIn('group_id', $val)
                ->orderBy('product_id', 'desc')
                ->simplePaginate($limit);
        }  

        $pl->getCollection() 
            ->transform(function ($value) { 
            //$url = Storage::url($value->IMAGE);
            $parts_type = SitePart::getPartsTypeById($value->product_id);
            $kitchen_loc = SitePart::getKitchenLocationById($value->product_id);
            
            return [
                'product_id'    => $value->product_id,
                'outlet_id'     => $value->outlet_id, 
                // 'description'   => $value->description,
                'description'   => $value->short_code,
                'srp'           => $value->retail,
                'category_id'   => $value->category,
                'group'         => [
                    'group_code'    => $value->group->group_id,
                    'description'   => $value->group->description
                ],  
                'image'         => '', 
                'is_food'       => $value->is_food,
                'is_postmix'    => $value->postmix,
                'parts_type'    => $parts_type,
                'kitchen_loc'   => $kitchen_loc
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
                'success'   => false,
                'status'    => 401,
                'message'   => 'Unauthorized Access'
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

        $val = config('custom.group_not_to_display');
        $val = explode(',',$val);         

        $groups = $pl->unique('group')
            ->whereNotIn('group.group_id',$val)
            ->transform(function ($value) {  
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

    public function getComponents(Request $request, $pid){

        $pl = PartLocation::where('outlet_id', $request->outlet_id) 
                ->where('product_id',$pid)
                ->first();

        $result = $pl->postmixModifiableComponents;

        if( !$result->isEmpty() ){

            $result->transform( function($v) use ($request) {

                // $pl = PartLocation::where('outlet_id', $request->outlet_id) 
                //         ->where('product_id',$v->product_id)
                //         ->first(); 
                //var_dump($v); 

                $parts_type = SitePart::getPartsTypeById($v->product_id);
                $kitchen_loc = SitePart::getKitchenLocationById($v->product_id);

                return [
                    'parent_id'         => $v->parent_id,
                    'product_id'        => $v->product_id,
                    'description'       => $v->description,
                    'quantity'          => $v->quantity,
                    'unit_cost'         => $v->unit_cost,
                    'rp'                => $v->partLocation->retail, 
                    'type'              => $v->type, 
                    'modifiable'        => $v->modifiable,
                    'product_category'  => $v->comp_cat_id,
                    'parts_type'        => $parts_type,
                    'kitchen_loc'       => $kitchen_loc
                ];
            }); 
        }

        return response()->json([
            'success'       => true,
            'status'        => 200,
            'data'          => $result
        ]); 

    } 

    public function getByGroup(Request $request, $id){

        // parts by location and group
        $list = PartLocation::where('outlet_id', $request->outlet_id)
                    // ->where('group_id', $id)
                    ->where('category_id', $id)
                    ->get();

        $list->transform(function ($value) {
            //$url = Storage::url($value->IMAGE);
            $parts_type = SitePart::getPartsTypeById($value->product_id);
            $kitchen_loc = SitePart::getKitchenLocationById($value->product_id);
            return [
                'product_id'    => $value->product_id,
                'outlet_id'     => $value->outlet_id, 
                'description'   => $value->description,
                'short_code'    => $value->short_code,
                'srp'           => $value->retail,
                'category_id'   => $value->category_id,
                'group'         => [
                    'group_code'    => $value->group->group_id,
                    'description'   => $value->group->description
                ],  
                'image'         => '', 
                'is_food'       => $value->is_food,
                'is_postmix'    => $value->postmix,
                'parts_type'    => $parts_type,
                'kitchen_loc'   => $kitchen_loc
            ];
        });


        return response()->json([
            'success'       => true,
            'status'        => 200,
            'data'          => $list
        ]); 
    }

    public function items(Request $request){

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
        
        $result = PartLocation::where('outlet_id', $duty->outlet)
            ->where('group_id', $request->group_id)
            ->where('category_id', $request->category_id)
            ->simplePaginate(15);

        $result->getCollection() 
            ->transform(function ($value) { 
            //$url = Storage::url($value->IMAGE);
            $parts_type = SitePart::getPartsTypeById($value->product_id);
            $kitchen_loc = SitePart::getKitchenLocationById($value->product_id);
            
            return [
                'product_id'    => $value->product_id,
                'outlet_id'     => $value->outlet_id, 
                // 'description'   => $value->description,
                'description'   => $value->short_code,
                'srp'           => $value->retail,
                'category_id'   => $value->category,
                'group'         => [
                    'group_code'    => $value->group->group_id,
                    'description'   => $value->group->description
                ],  
                'image'         => '', 
                'is_food'       => $value->is_food,
                'is_postmix'    => $value->postmix,
                'parts_type'    => $parts_type,
                'kitchen_loc'   => $kitchen_loc
            ];
        });

        return response()->json([
            'success'   => true,
            'status'    => 200,
            'result'    => [
                'data'  => $result
            ]
        ]);

    }

}
