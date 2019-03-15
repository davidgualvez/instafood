<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\OrderSlipHeader;
use App\Services\BranchLastIssuedNumberServices; 
use Carbon\Carbon;
use App\Model\User;
use DB, Log;
use App\Services\Helper;
use function GuzzleHttp\json_decode;

class OrderSlipHeaderController extends Controller
{
    //
    public function storeEmpty(Request $request){

        try{
            DB::beginTransaction();

            $blin = new BranchLastIssuedNumberServices;
            $blin->findOrCreate();
 
            $helper = new Helper;
            $now    = Carbon::now();

            $user = User::where('token', $request->header('token'))
                ->first();

            if (is_null($user)) {
                return response()->json([
                    'success'   => false,
                    'status'    => 401,
                    'message'   => 'Unauthorized Access'
                ]);
            }  

            $osh = new OrderSlipHeader;
            $osh->orderslip_header_id       = $blin->getNewIdForOrderSlipHeader();
            $osh->branch_id                 = config('custom.branch_id');
            $osh->transaction_type_id       = 1;
            $osh->total_amount              = 0;
            $osh->discount_amount           = 0;
            $osh->net_amount                = 0;
            $osh->status                    = 'S'; // selected
            $osh->created_at                = $now;
            $osh->orig_invoice_date         = $helper->getClarionDate($now);
            $osh->encoded_date              = $now;
            $osh->encoded_by                = $user->username;
            $osh->prepared_by               = $user->name;
            $osh->cce_name                  = $user->name;
            $osh->save(); 

            /**
             * Committing all changes in the database
             */
            DB::commit();
            return response()->json([
                'success'   => true,
                'status'    => 200,
                'message'   => 'Success',
                'result'    => [
                    'order_slip_no'     => $osh->orderslip_header_id
                ]
            ]); 
            
        }catch(\Exception $e){
            DB::rollback();
            Log::error($e->getMessage());
            
            return response()->json([
                'success'   => false,
                'status'    => 400,
                'message'   => 'Server Error',
                'detail'    => $e->getMessage()
            ],500);
        }

        return response()->json([
            'success'       => false,
            'status'        => 200,
            'message'       => 'success'
        ]);
    }

    public function addNewItem(Request $request){

        $item = json_decode($request->item);
        dd($item);
        return response()->json([
            'data'  => $item
        ]);
    }
}
