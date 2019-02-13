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
            
        $userServices = new UserServices($user);
        $helper = new Helper; 
 
        $duty = $userServices->isOnDuty($helper->getClarionDate($now));
        
        /**
         * GET PRODUCT BELONGS TO OUTLET
         */
        $pl = PartLocation::where('outlet_id', $duty->outlet)->get();

        /**
         * GET DISTINCT CATEGORY
         */

        dd($pl);
    }
}
