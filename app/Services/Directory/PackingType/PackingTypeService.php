<?php
namespace App\Services\Directory\PackingType;
use App\Models\Directory\PackingTypeDirectory;

class PackingTypeService
{

    public static function index() {
        return PackingTypeDirectory::where(['deleted_at'=> null])->get();
    }
    public static function create($data){  
        return PackingTypeDirectory::create($data);
    }
    public static function card($id){ 
        return PackingTypeDirectory::find($id);
    }
    public static function update($id, $data){ 
        $model = PackingTypeDirectory::find($id);
        if(!$model) return null; 
        $model->updateOrFail($data);
        return $model;
    }
    public static function delete($id){ 
        $model = PackingTypeDirectory::find($id);
        if(!$model) return null; 
        return $model->update(['deleted_at' => now()]);
    }
    public static function recover($id){ 
        $model = PackingTypeDirectory::find($id);
        if(!$model) return null; 
        return $model->update(['deleted_at' => null]);
    }
}