<?php
namespace App\Services\StatusPurchase;

use App\Models\StatusPurchase;

class StatusPurchaseService
{

    public static function index() {
        return StatusPurchase::where(['deleted_at'=> null])->get();
    }
    public static function create($data){  
        return StatusPurchase::create($data);
    }
    public static function card($id){ 
        return StatusPurchase::findOrFail($id);
    }
    public static function update($id, $data){ 
        return StatusPurchase::findOrFail($id)->update($data);
    }
    public static function delete($id){ 
        return StatusPurchase::findOrFail($id)->updateOrFail(['deleted_at' => now()]);
    }
    public static function recover($id){ 
        return StatusPurchase::findOrFail($id)->updateOrFail(['deleted_at'=> null]);
    }

}