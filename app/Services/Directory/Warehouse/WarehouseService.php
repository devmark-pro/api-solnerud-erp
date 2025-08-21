<?php
namespace App\Services\Directory\Warehouse;
use App\Models\Directory\WarehouseDirectory;

class WarehouseService
{
    public static function index() {
        return WarehouseDirectory::where(['deleted_at'=> null])->get();
    }
    public static function create($data){  
        return WarehouseDirectory::create($data);
    }
    public static function card($id){ 
        return WarehouseDirectory::find($id);
    }
    public static function update($id, $data){ 
        $model = WarehouseDirectory::find($id);
        if(!$model) return null; 
        $model->updateOrFail($data);
        return $model;
    }
    public static function delete($id){ 
        $model = WarehouseDirectory::find($id);
        if(!$model) return null; 
        return $model->update(['deleted_at' => now()]); 
    }
    public static function recover($id){ 
        $model = WarehouseDirectory::find($id);
        if(!$model) return null; 
        return $model->update(['deleted_at' => null]);
    }
}