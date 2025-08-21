<?php
namespace App\Services\Directory\TypeFlow;
use App\Models\Directory\TypeFlowDirectory;

class TypeFlowService
{

    public static function index() {
        return TypeFlowDirectory::where(['deleted_at'=> null])->get();
    }
    public static function create($data){  
        return TypeFlowDirectory::create($data);
    }
    public static function card($id){ 
        return TypeFlowDirectory::find($id);
    }
    public static function update($id, $data){ 
        $model = TypeFlowDirectory::find($id);
        if(!$model) return null; 
        $model->updateOrFail($data);
        return $model;
    }
    public static function delete($id){ 
        $model = TypeFlowDirectory::find($id);
        if(!$model) return null; 
        return $model->update(['deleted_at' => now()]); 
    }
    public static function recover($id){ 
        $model = TypeFlowDirectory::find($id);
        if(!$model) return null; 
        return $model->update(['deleted_at' => null]);
    }
}