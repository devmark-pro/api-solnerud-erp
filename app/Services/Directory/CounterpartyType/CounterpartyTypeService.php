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
    public static function card($id){ 
        return CounterpartyTypeDirectory::findOrFail($id);
    }
    public static function update($id, $data){ 
        return CounterpartyTypeDirectory::findOrFail($id)->update($data);
    }
    public static function delete($id){ 
        return CounterpartyTypeDirectory::findOrFail($id)->updateOrFail(['deleted_at' => now()]);
    }
    public static function recover($id){ 
        return CounterpartyTypeDirectory::findOrFail($id)->updateOrFail(['deleted_at'=> null]);
    }

}