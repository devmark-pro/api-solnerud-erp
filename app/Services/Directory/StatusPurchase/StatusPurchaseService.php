<?php
namespace App\Services\Directory\StatusPurchase;

use App\Models\Directory\StatusPurchaseDirectory;

class StatusPurchaseService
{

    public static function index() {
        return StatusPurchaseDirectory::where(['deleted_at'=> null])->get();
    }
    public static function create($data){  
        return StatusPurchaseDirectory::create($data);
    }
    public static function card($id){ 
        return StatusPurchaseDirectory::findOrFail($id);
    }
    public static function update($id, $data){ 
        return StatusPurchaseDirectory::findOrFail($id)->update($data);
    }
    public static function delete($id){ 
        return StatusPurchaseDirectory::findOrFail($id)->updateOrFail(['deleted_at' => now()]);
    }
    public static function recover($id){ 
        return StatusPurchaseDirectory::findOrFail($id)->updateOrFail(['deleted_at'=> null]);
    }

}