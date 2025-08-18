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
        return PurchaseTypeDirectory::findOrFail($id);
    }
    public static function update($id, $data){ 
        return PurchaseTypeDirectory::findOrFail($id)->update($data);
    }
    public static function delete($id){ 
        return PurchaseTypeDirectory::findOrFail($id)->updateOrFail(['deleted_at' => now()]);
    }
    public static function recover($id){ 
        return PurchaseTypeDirectory::findOrFail($id)->updateOrFail(['deleted_at'=> null]);
    }

}