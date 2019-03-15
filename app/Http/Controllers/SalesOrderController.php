<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Model\User;
use App\Model\Customer;
use App\Model\OrderSlipHeader;
use App\Model\OrderSlipDetail;
use App\Model\KitchenOrder;
use App\Model\Postmix;
use App\Services\BranchLastIssuedNumberServices;
use App\Services\Helper;
use Carbon\Carbon;
use DB;

class SalesOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    { 
        //dd($request->items);

        //
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
            $osh->status                    = 'P'; //Pending
            
            // get the customer info if not null
            if($request->others['mobile_number'] != null){
                $customer = new Customer;
                $customer_result = $customer->findByMobile( $request->others['mobile_number']); 
                $osh->customer_id               = $customer_result->customer_id;
                $osh->mobile_number             = $customer_result->mobile_number;
                $osh->customer_name             = $customer_result->name;
            } 
            // end
           
            $osh->created_at                = $now;
            $osh->orig_invoice_date         = $helper->getClarionDate($now);
            $osh->encoded_date              = $now;
            $osh->encoded_by                = $user->username;
            $osh->prepared_by               = $user->name;
            $osh->cce_name                  = $user->name;
            $osh->total_hc                  = $request->others['headcounts']['regular'];
            $osh->save();

            $counter    = 1; 
 
            foreach( $request->items as $item){ 

                $order_type = 0;

                if($item['order_type'] == 'dine-in'){
                    $order_type = 1;
                }else if( $item['order_type'] == 'take-out'){
                    $order_type = 2;
                }

                $base_line_number = $counter;

                //save each of the item in OrderSlip
                $osd = new OrderSlipDetail;
                $osd->orderslip_detail_id           = $blin->getNewIdForOrderSlipDetails();
                $osd->orderslip_header_id           = $osh->orderslip_header_id;
                $osd->branch_id                     = config('custom.branch_id');
                $osd->remarks                       = $item['instruction'];
                $osd->line_number                   = $base_line_number; 
                $osd->order_type                    = $order_type;
                $osd->product_id                    = $item['item']['product_id'];
                $osd->qty                           = $item['ordered_qty'];
                $osd->srp                           = $item['item']['srp'];  
                $osd->amount                        = $item['item']['srp'];
                $osd->net_amount                    = $item['ordered_qty'] * $item['item']['srp'];
                $osd->status                        = 'P';
                $osd->postmix_id                    = $item['item']['product_id'];
                $osd->is_modify                     = null;
                if($request->others['mobile_number'] != null){
                    $osd->customer_id               = $osh->customer_id;
                }
                $osd->encoded_date                  = $now;
                $osd->save(); 

                //save to kitchen
                // if( strtolower($item['item']['parts_type']) == 'y'){
                //     $this->saveToKitchen( 
                //             $blin->getNewIdForKitchenOrder(),
                //             $osh->orderslip_header_id,
                //             $osd->orderslip_detail_id,
                //             $item['item']['product_id'],
                //             $item['item']['product_id'],
                //             $item['item']['kitchen_loc'],
                //             $item['ordered_qty'],
                //             $now,
                //             $helper->getClarionDate($now),
                //             $helper->getClarionTime($now)); 
                // }

                if( isset($item['components']) ){
                    //reading components
                    foreach( $item['components'] as $components){
                         
                        if( $components['item']['quantity'] > 0){ 
                            $counter++;
                            //save each of the item in OrderSlip
                            $osd1 = new OrderSlipDetail; 
                            $osd1->orderslip_detail_id           = $blin->getNewIdForOrderSlipDetails();
                            $osd1->orderslip_header_id           = $osh->orderslip_header_id;
                            $osd1->branch_id                     = config('custom.branch_id');
                            $osd1->remarks                       = $osd->remarks;
                            $osd1->line_number                   = $counter;
                            $osd1->order_type                    = $order_type;
                            $osd1->product_id                    = $components['item']['product_id'];
                            $osd1->srp                           = 0;
                            $osd1->qty                           = $components['item']['quantity']; 
                            $osd1->amount                        = 0;
                            $osd1->net_amount                    = $components['item']['quantity'] * 0;
                            $osd1->status                        = 'P';
                            $osd1->postmix_id                    = $osd->product_id;
                            $osd1->is_modify                     = 1;
                            $osd1->or_number                     = $base_line_number;
                            $osd1->old_comp_id                   = $components['item']['product_id'];
                            if($request->others['mobile_number'] != null){
                                $osd1->customer_id               = $osh->customer_id;
                            }
                            $osd1->encoded_date                  = $now;
                            $osd1->save();

                            //save to kitchen
                            // if(strtolower( $components['item']['parts_type']) == 'y'){
                            //     $this->saveToKitchen(
                            //         $blin->getNewIdForKitchenOrder(),
                            //         $osh->orderslip_header_id,
                            //         $osd1->orderslip_detail_id,
                            //         $osd1->product_id,
                            //         $osd->product_id,
                            //         $components['item']['kitchen_loc'],
                            //         $osd1->qty,
                            //         $now,
                            //         $helper->getClarionDate($now),
                            //         $helper->getClarionTime($now)); 
                            // }
                            
                        }

                        foreach( $components[ 'selectable_items'] as $sitems){
                            if($sitems['qty'] > 0){
                                $counter++;
                                //save each of the item in OrderSlip
                                $osd2 = new OrderSlipDetail;
                                $osd2->orderslip_detail_id           = $blin->getNewIdForOrderSlipDetails();
                                $osd2->orderslip_header_id           = $osh->orderslip_header_id;
                                $osd2->branch_id                     = config('custom.branch_id');
                                $osd2->remarks                       = $osd->remarks;
                                $osd2->line_number                   = $counter;
                                $osd2->order_type                    = $order_type;
                                $osd2->product_id                    = $sitems['product_id'];
                                $osd2->srp                           = $sitems['price'];
                                $osd2->qty                           = $sitems['qty'];

                                $osd2->amount                        = $sitems['price'];
                                $osd2->net_amount                    = $sitems['qty'] * $sitems['price'];
                                $osd2->status                        = 'P';
                                $osd2->postmix_id                    = $osd->product_id;
                                $osd2->is_modify                     = 1;
                                $osd2->or_number                     = $base_line_number;
                                $osd2->old_comp_id                   = $components['item']['product_id'];
                                if($request->others['mobile_number'] != null){
                                    $osd2->customer_id               = $osh->customer_id;
                                }
                                $osd2->encoded_date                  = $now;
                                $osd2->save();

                                //save to kitchen
                                // if(strtolower( $sitems['parts_type']) == 'y'){
                                //     $this->saveToKitchen(
                                //         $blin->getNewIdForKitchenOrder(),
                                //         $osh->orderslip_header_id,
                                //         $osd2->orderslip_detail_id,
                                //         $osd2->product_id,
                                //         $osd->product_id,
                                //         $sitems['kitchen_loc'],
                                //         $osd2->qty,
                                //         $now,
                                //         $helper->getClarionDate($now),
                                //         $helper->getClarionTime($now)); 
                                // }
                                    
                            }
                        }
                        
                    }
                }

                //save other none modifiable components that can be save to the kitchen
                $pm = Postmix::where('parent_id', $osd->product_id)
                        ->where('MODIFIABLE', 0)
                        ->get();
                
                foreach ($pm as $key => $value) {
                    # code...
                    // dd($value);
                    $counter++;
                    $pm_qty = $value->quantity * $item['ordered_qty'];
                    $pm_amount = $pm_qty * 0;
                    $_osd = new OrderSlipDetail;
                    $_osd->orderslip_detail_id           = $blin->getNewIdForOrderSlipDetails();
                    $_osd->orderslip_header_id           = $osh->orderslip_header_id;
                    $_osd->branch_id                     = config('custom.branch_id');
                    $_osd->remarks                       = $item['instruction'];
                    $_osd->line_number                   = $counter;
                    $_osd->order_type                    = $order_type;
                    $_osd->product_id                    = $value->product_id;
                    $_osd->qty                           = $pm_qty;
                    $_osd->srp                           = 0;
                    $_osd->amount                        = $pm_amount;
                    $_osd->net_amount                    = 0;
                    $_osd->status                        = 'P';
                    $_osd->postmix_id                    = $osd->product_id;
                    $_osd->is_modify                     = null;
                    if($request->others['mobile_number'] != null){
                        $_osd->customer_id                = $osh->customer_id;
                    }
                    $_osd->encoded_date                  = $now;
                    $_osd->save();



                    // if( strtolower($value->sitePart->parts_type) == 'y'){
                    //     $this->saveToKitchen(
                    //         $blin->getNewIdForKitchenOrder(),
                    //         $osh->orderslip_header_id,
                    //         $osd->orderslip_detail_id,
                    //         $osd->product_id,
                    //         $value->product_id,
                    //         $value->sitePart->kitchen_loc,
                    //         ($osd->qty * $value->quantity),
                    //         $now,
                    //         $helper->getClarionDate($now),
                    //         $helper->getClarionTime($now));
                    // }

                }

            }

            /**
             * Committing all changes in the database
             */
            DB::commit();
            return response()->json([
                'success'   => true,
                'status'    => 200,
                'message'   => 'Success',
                'data'      => [
                    'orderslip_id'  => $osh->orderslip_header_id,
                    'created_at'    => $now->toDateTimeString()
                ]
            ]);

        }catch(\Exception $e) {
            DB::rollback();
            return response()->json([
                'success'   => false,
                'status'    => 400,
                'message'   => 'Server Error',
                'detail'    => $e->getMessage()
            ]);
        } 
    }

    private function saveToKitchen(
            $ko_id,$header_id,$detail_id,
            $part_id,$comp_id,$location_id,$qty,$datenow,$cdate,$ctime){
        $ko = new KitchenOrder;
        $ko->branch_id          = config('custom.branch_id');
        $ko->ko_id              = $ko_id;
        $ko->transact_type      = 1;
        $ko->header_id          = $header_id;
        $ko->detail_id          = $detail_id;
        $ko->part_id            = $part_id;
        $ko->comp_id            = $comp_id;
        $ko->location_id        = $location_id;
        $ko->qty                = $qty;
        $ko->balance            = $qty;
        $ko->status             = 'P';
        $ko->created_at         = $datenow;
        $ko->created_date       = $cdate;
        $ko->created_time       = $ctime;
        $ko->save();

        return $ko;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
