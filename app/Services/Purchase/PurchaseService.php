<?php
namespace App\Services\Purchase;
use App\Models\Purchase;

class PurchaseService
{
    public static function index() {
        return Purchase::where(['deleted_at'=> null])->get();
    }
    public static function create($data){  
        return Purchase::create($data);
    }
    public static function card($id){ 
        return Purchase::findOrFail($id);
    }
    public static function update($id, $data){ 
        return Purchase::findOrFail($id)->update($data);
    }
    public static function delete($id){ 
        return Purchase::findOrFail($id)->updateOrFail(['deleted_at' => now()]);
    }
    public static function recover($id){ 
        return Purchase::findOrFail($id)->updateOrFail(['deleted_at'=> null]);
    }

}