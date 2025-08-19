<?php
namespace App\Services\Nomenclature;
use App\Models\Nomenclature;

class NomenclatureService
{
    public static function index() {
        return Nomenclature::where(['deleted_at'=> null])->get();
    }
    public static function create($data){  
        return Nomenclature::create($data);
    }
    public static function card($id){ 
        return Nomenclature::find($id);
    }
    public static function update($id, $data){ 
        $model = Nomenclature::find($id);
        if(!$model) return null; 
        $model->updateOrFail($data);
        return $model;
    }
    public static function delete($id){ 
        $model = Nomenclature::find($id);
        if(!$model) return null; 
        $model->update(['deleted_at' => now()]);
        return $model; 
    }
    public static function recover($id){ 
        $model = Nomenclature::find($id);
        if(!$model) return null; 
        $model->update(['deleted_at' => null]);
        return $model; 
    }
}