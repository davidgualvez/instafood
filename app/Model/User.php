<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

use Sofa\Eloquence\Eloquence; // base trait
use Sofa\Eloquence\Mappable; // extension trait
use Sofa\Eloquence\Mutable; // extension trait

class User extends Model
{
    use Eloquence, Mappable, Mutable;
    //
    protected $table        = 'UserSite';
    protected $primaryKey   = 'ID';
    public $timestamps = false;

    /**
     * Model Mapping
     */
    protected $maps = [  
      'username'        => 'NUMBER', 
      'password'        => 'PW',
      'token'           => 'TOKEN',
      'name'            => 'NAME'
    ];

    protected $getterMutators = [
        'password'  => 'trim',
        'name'      => 'trim'
    ];

    /**
     * RELATIONSHIT
     */
    public function duties(){
      return $this->hasMany('App\Model\OnDuty', 'CCENUMBER', 'username');
    }

}
