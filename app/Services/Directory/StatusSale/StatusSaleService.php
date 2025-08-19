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
        return StatusSaleDirectory::find($id);
    }
    public static function update($id, $data){ 
        $model = StatusSaleDirectory::find($id);
        if(!$model) return null; 
        $model->updateOrFail($data);
        return $model;
    }
    public static function delete($id){ 
        $model = StatusSaleDirectory::find($id);
        if(!$model) return null; 
        $model->update(['deleted_at' => now()]);
        return $model; 
    }
    public static function recover($id){ 
        $model = StatusSaleDirectory::find($id);
        if(!$model) return null; 
        $model->update(['deleted_at' => null]);
        return $model; 
    }

}