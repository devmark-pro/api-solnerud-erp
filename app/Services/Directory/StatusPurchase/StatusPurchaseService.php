<?php
namespace App\Services\Directory\StatusPurchase;

use App\Models\Directory\StatusPurchaseDirectory;

class StatusPurchaseService
{

    public static function index() {
        return StatusPurchaseDirectory::where(['deleted_at'=> null])->get();
    }
    public static function create($data){  
        return StatusPurchaseDirectory::create($data);
    }
    public static function card($id){ 
        return StatusPurchaseDirectory::find($id);
    }
    public static function update($id, $data){ 
        $model = StatusPurchaseDirectory::find($id);
        if(!$model) return null; 
        $model->updateOrFail($data);
        return $model;
    }
    public static function delete($id){ 
        $model = StatusPurchaseDirectory::find($id);
        if(!$model) return null; 
        return $model->update(['deleted_at' => now()]);
    }
    public static function recover($id){ 
        $model = StatusPurchaseDirectory::find($id);
        if(!$model) return null; 
        return $model->update(['deleted_at' => null]);
    }
}