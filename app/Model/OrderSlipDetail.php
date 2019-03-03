<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Sofa\Eloquence\Eloquence; // base trait
use Sofa\Eloquence\Mappable; // extension trait
use Sofa\Eloquence\Mutable; // extension trait

class OrderSlipDetail extends Model
{
    use Eloquence, Mappable, Mutable;
    //
    protected $table 		= 'OrderSLipDetails';
    public $timestamps 		= false;

    //model mapping
    protected $maps = [ 
    	'branch_id' 			=> 'BRANCHID', 
    	'orderslip_detail_id' 	=> 'ORDERSLIPDETAILID', 
     	'orderslip_header_id' 	=> 'ORDERSLIPNO', 
    	'product_id' 			=> 'PRODUCT_ID', 
    	'part_number'			=> 'PARTNO', 
    	'product_group_id'		=> 'PRODUCTGROUP', 
    	'qty' 					=> 'QUANTITY', 
    	'srp' 					=> 'RETAILPRICE', 
		'amount' 				=> 'AMOUNT',
        'net_amount'            => 'NETAMOUNT',
		'remarks'				=> 'REMARKS',
		'order_type'			=> 'OSTYPE',  
		'status'				=> 'STATUS',
		'postmix_id' 			=> 'POSTMIXID',
		'is_modify'				=> 'IS_MODIFY',
        'line_number'           => 'LINE_NO',
        'old_comp_id'           => 'OLD_COMP_ID',
		'or_number' 			=> 'ORNO',
		'customer_id'			=> 'CUSTOMERCODE',
        'encoded_date'          => 'ENCODEDDATE',
    ];
}
