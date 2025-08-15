<?php
namespace App\Services\Directory\StatusPurchase;

use App\Models\Directory\DirectoryStatusPurchase;

class StatusPurchaseService
{

    public static function index() {
        return DirectoryStatusPurchase::where(['deleted_at'=> null])->get();
    }
    public static function create($data){  
        return DirectoryStatusPurchase::create($data);
    }
    public static function card($id){ 
        return DirectoryStatusPurchase::findOrFail($id);
    }
    public static function update($id, $data){ 
        return DirectoryStatusPurchase::findOrFail($id)->update($data);
    }
    public static function delete($id){ 
        return DirectoryStatusPurchase::findOrFail($id)->updateOrFail(['deleted_at' => now()]);
    }
    public static function recover($id){ 
        return DirectoryStatusPurchase::findOrFail($id)->updateOrFail(['deleted_at'=> null]);
    }

}