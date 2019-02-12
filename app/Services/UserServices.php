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

    public function get(){
        return $this->model;
    }

    public function generateToken(){
        $now = Carbon::now();

        $newToken = Hash::make($this->model->username.$now);

        $this->model->token = $newToken;
        $this->model->update();

        return $newToken;
    }

}