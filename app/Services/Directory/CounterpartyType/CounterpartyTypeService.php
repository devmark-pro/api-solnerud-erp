<?php
namespace App\Services\Directory\CounterpartyType;
use App\Models\Directory\CounterpartyTypeDirectory;

class CounterpartyTypeService
{
    public static function index() {
        return CounterpartyTypeDirectory::where(['deleted_at'=> null])->get();
    }
    public static function create($data){  
        return CounterpartyTypeDirectory::create($data);
    }
    public static function update($id, $data){ 
        $model = CounterpartyTypeDirectory::find($id);
        if(!$model) return null; 
        $model->updateOrFail($data);
        return $model;
    }
    public static function delete($id){ 
        $model = CounterpartyTypeDirectory::find($id);
        if(!$model) return null; 
        $model->update(['deleted_at' => now()]);
        return $model; 
    }
    public static function recover($id){ 
        $model = CounterpartyTypeDirectory::find($id);
        if(!$model) return null; 
        $model->update(['deleted_at' => null]);
        return $model; 
    }
}