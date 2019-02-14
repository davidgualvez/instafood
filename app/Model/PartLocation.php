<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

use Sofa\Eloquence\Eloquence; // base trait
use Sofa\Eloquence\Mappable; // extension trait
use Sofa\Eloquence\Mutable; // extension trait

class PartLocation extends Model
{
    //
    use Eloquence, Mappable, Mutable;
    //
    protected $table    = 'PartsLocation';
    public $timestamps  = false;

    /**
     * Model Mapping
     */
    protected $maps = [
        'product_id'    => 'PRODUCT_ID',
        'outlet_id'     => 'OUTLETID',
        'description'   => 'DESCRIPTION',
        'group_id'         => 'GROUP',
        'category_id'      => 'CATEGORY',
        'short_code'    => 'SHORTCODE',
        'retail'        => 'RETAIL',
        'postmix'       => 'POSTMIX',
        'prepartno'     => 'PREPARTNO',
        'ssbuffer'      => 'SSBUFFER',
        'is_food'       => 'MSGROUP',
        'qty'           => 'QUANTITY'
    ];

    protected $getterMutators = [
        'description'   => 'trim',
        'group_id'         => 'trim',
        'category'      => 'trim',
        'short_code'    => 'trim',
    ];

    /**
     * RELATIONSHIT
     */
    public function group(){
        return $this->belongsTo('App\Model\Group', 'group_id');
    }

}
