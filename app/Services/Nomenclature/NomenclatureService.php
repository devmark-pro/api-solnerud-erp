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
        return Nomenclature::findOrFail($id);
    }
    public static function update($id, $data){ 
        return Nomenclature::findOrFail($id)->update($data);
    }
    public static function delete($id){ 
        return Nomenclature::findOrFail($id)->updateOrFail(['deleted_at' => now()]);
    }
    public static function recover($id){ 
        return Nomenclature::findOrFail($id)->updateOrFail(['deleted_at'=> null]);
    }

}