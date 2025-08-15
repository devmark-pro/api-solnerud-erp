<?php
namespace App\Services\StatusSale;

use App\Models\StatusSale;

class StatusSaleService
{

    public static function index() {
        return StatusSale::where(['deleted_at'=> null])->get();
    }
    public static function create($data){  
        return StatusSale::create($data);
    }
    public static function card($id){ 
        return StatusSale::findOrFail($id);
    }
    public static function update($id, $data){ 
        return StatusSale::findOrFail($id)->update($data);
    }
    public static function delete($id){ 
        return StatusSale::findOrFail($id)->updateOrFail(['deleted_at' => now()]);
    }
    public static function recover($id){ 
        return StatusSale::findOrFail($id)->updateOrFail(['deleted_at'=> null]);
    }

}