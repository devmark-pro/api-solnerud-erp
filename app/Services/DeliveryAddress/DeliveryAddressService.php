<?php

namespace App\Services\DeliveryAddress;

use App\Models\DeliveryAddress;

class DeliveryAddressService
{
    public static function index() {
        return DeliveryAddress::where(['deleted_at'=> null])->get();
    }
    public static function create($data){  
        return DeliveryAddress::create($data);
    }
    public static function card($id){ 
        return DeliveryAddress::find($id);
    }
    public static function update($id, $data){ 
        $model = DeliveryAddress::find($id);
        if(!$model) return null; 
        $model->updateOrFail($data);
        return $model;
    }
    public static function delete($id){ 
        $model = DeliveryAddress::find($id);
        if(!$model) return null; 
        return $model->update(['deleted_at' => now()]);
    }
    public static function recover($id){ 
        $model = DeliveryAddress::find($id);
        if(!$model) return null; 
        return $model->update(['deleted_at' => null]);
    }
}