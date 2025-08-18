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
        return PackingTypeDirectory::findOrFail($id);
    }
    public static function update($id, $data){ 
        return PackingTypeDirectory::findOrFail($id)->update($data);
    }
    public static function delete($id){ 
        return PackingTypeDirectory::findOrFail($id)->updateOrFail(['deleted_at' => now()]);
    }
    public static function recover($id){ 
        return PackingTypeDirectory::findOrFail($id)->updateOrFail(['deleted_at'=> null]);
    }

}