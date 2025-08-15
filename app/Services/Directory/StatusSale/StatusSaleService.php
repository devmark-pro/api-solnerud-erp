<?php
namespace App\Services\Directory\StatusSale;

use App\Models\Directory\DirectoryStatusSale;

class StatusSaleService
{

    public static function index() {
        return DirectoryStatusSale::where(['deleted_at'=> null])->get();
    }
    public static function create($data){  
        return DirectoryStatusSale::create($data);
    }
    public static function card($id){ 
        return DirectoryStatusSale::findOrFail($id);
    }
    public static function update($id, $data){ 
        return DirectoryStatusSale::findOrFail($id)->update($data);
    }
    public static function delete($id){ 
        return DirectoryStatusSale::findOrFail($id)->updateOrFail(['deleted_at' => now()]);
    }
    public static function recover($id){ 
        return DirectoryStatusSale::findOrFail($id)->updateOrFail(['deleted_at'=> null]);
    }

}