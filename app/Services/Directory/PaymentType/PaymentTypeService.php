<?php
namespace App\Services\Directory\PaymentType;
use App\Models\Directory\PaymentTypeDirectory;

class PaymentTypeService
{

    public static function index() {
        return PaymentTypeDirectory::where(['deleted_at'=> null])->get();
    }
    public static function create($data){  
        return PaymentTypeDirectory::create($data);
    }
    public static function card($id){ 
        return PaymentTypeDirectory::find($id);
    }
    public static function update($id, $data){ 
        $model = PaymentTypeDirectory::find($id);
        if(!$model) return null; 
        $model->updateOrFail($data);
        return $model;
    }
    public static function delete($id){ 
        $model = PaymentTypeDirectory::find($id);
        if(!$model) return null; 
        $model->update(['deleted_at' => now()]);
        return $model; 
    }
    public static function recover($id){ 
        $model = PaymentTypeDirectory::find($id);
        if(!$model) return null; 
        $model->update(['deleted_at' => null]);
        return $model; 
    }

}