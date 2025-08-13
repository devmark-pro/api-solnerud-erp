<?php
namespace App\Services\Status;

use App\Models\Status;

class StatusService
{

    public static function index(){
        return Status::get();
    }

    public static function create($data){
        
        return Status::create($data);
        // return //Status::get();
    }

}