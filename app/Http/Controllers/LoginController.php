<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Model\User;
use App\Services\UserServices;
use App\Services\Helper;

use DB;
use Carbon\Carbon;

class LoginController extends Controller
{
    //
    public function show(){
        return view('login');
    }

    public function login(Request $request){

        try { 
            DB::beginTransaction();

            $now = Carbon::now();

            $user = User::where('username', $request->username)
                ->first();

            if( is_null($user) ){
                DB::rollback();
                return response()->json([
                    'success'   => false,
                    'status'    => 400,
                    'message'   => 'Invalid Username'
                ]);
            }
            
            if ( $user->password != $request->password ) {
                DB::rollback();
                return response()->json([
                    'success' => false,
                    'status' => 400,
                    'message' => 'Invalid Password'
                ]);
            }

            $helper = new Helper;  

            $userServices = new UserServices($user);  
            if( !$userServices->isOnDuty($helper->getClarionDate($now)) ){
                return response()->json([
                    'success'   => false,
                    'status'    => 400,
                    'message'   => 'Not on duty!'
                ]);
            }

            $token = $userServices->generateToken(); 

            /**
             * Committing all changes in the database
             */
            DB::commit();

            return response()->json([
                'success'   => true,
                'status'    => 200,
                'message'   => 'Access Granted',
                'token'     => $token
            ]);

        }catch(\Exception $e){ 
            DB::rollback();
            return response()->json([
                'success'   => false,
                'status'    => 400,
                'message'   => 'Invalid Request'
            ]);
        }
       
    }
}
