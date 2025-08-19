<?php
namespace App\Services\Directory\DeliveryMethod;
use App\Models\Directory\DeliveryMethodDirectory;

class DeliveryMethodService
{

    public static function index() {
        return DeliveryMethodDirectory::where(['deleted_at'=> null])->get();
    }
    public static function create($data){  
        return DeliveryMethodDirectory::create($data);
    }
    public static function update($id, $data){ 
        $model = DeliveryMethodDirectory::find($id);
        if(!$model) return null; 
        $model->updateOrFail($data);
        return $model;
    }
    public static function delete($id){ 
        $model = DeliveryMethodDirectory::find($id);
        if(!$model) return null; 
        $model->update(['deleted_at' => now()]);
        return $model; 
    }
    public static function recover($id){ 
        $model = DeliveryMethodDirectory::find($id);
        if(!$model) return null; 
        $model->update(['deleted_at' => null]);
        return $model; 
    }

}