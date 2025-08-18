<?php
namespace App\Services\Directory\StatusSale;

use App\Models\Directory\StatusSaleDirectory;

class StatusSaleService
{

    public static function index() {
        return StatusSaleDirectory::where(['deleted_at'=> null])->get();
    }
    public static function create($data){  
        return StatusSaleDirectory::create($data);
    }
    public static function card($id){ 
        return StatusSaleDirectory::findOrFail($id);
    }
    public static function update($id, $data){ 
        return StatusSaleDirectory::findOrFail($id)->update($data);
    }
    public static function delete($id){ 
        return StatusSaleDirectory::findOrFail($id)->updateOrFail(['deleted_at' => now()]);
    }
    public static function recover($id){ 
        return StatusSaleDirectory::findOrFail($id)->updateOrFail(['deleted_at'=> null]);
    }

}