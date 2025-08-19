<?php
namespace App\Services\Directory\PurchaseType;

use App\Models\Directory\PurchaseTypeDirectory;

class PurchaseTypeService
{

    public static function index() {
        return PurchaseTypeDirectory::where(['deleted_at'=> null])->get();
    }
    public static function create($data){  
        return PurchaseTypeDirectory::create($data);
    }
    public static function card($id){ 
        return PurchaseTypeDirectory::find($id);
    }
    public static function update($id, $data){ 
        $model = PurchaseTypeDirectory::find($id);
        if(!$model) return null; 
        $model->updateOrFail($data);
        return $model;
    }
    public static function delete($id){ 
        $model = PurchaseTypeDirectory::find($id);
        if(!$model) return null; 
        $model->update(['deleted_at' => now()]);
        return $model; 
    }
    public static function recover($id){ 
        $model = PurchaseTypeDirectory::find($id);
        if(!$model) return null; 
        $model->update(['deleted_at' => null]);
        return $model; 
    }

}