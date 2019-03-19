<?php

namespace App\Services;

use App\Model\User;
use Carbon\Carbon;
use Hash;

class UserServices {

   // model property on class instances
    protected $model;

    // Constructor to bind model to repo
    public function __construct(User $model)
    {
        $this->model = $model;
    }

    /**
     * GET
     */
    public function get(){
        return $this->model;
    }
    public function getToken(){
        return $this->model->token;
    }
    public function getOutlet(){
        return $this->model->outlet;
    }
    
    /**
     * SET
     */

    /**
     * LOGIC
     */ 
    public function generateToken(){
        $now = Carbon::now();

        $newToken = Hash::make($this->model->username.$now);

        $this->model->token = $newToken;
        $this->model->update();

        return $newToken;
    } 
    
    public function isOnDuty($clarionDate){
        
        $result = $this->model->duties; 
         
        if( $result->isEmpty() ){
            return false;
        }

        foreach ($result as $key => $value) {
            if($value->date == $clarionDate){
                return $value;
            }
        }

        return false;
    }

}