<?php
namespace App\Services\Directory\StatusPurchase;

use App\Models\Directory\StatusPurchaseDirectory;

class StatusPurchaseService
{

    public static function index($page = 1 ,$limit = 100 ) {

        $offset = $limit * ($page-1);
        $model = StatusPurchaseDirectory::where(['deleted_at'=> null]);
        $count = $model->get()->count();
        $pagesCount= ceil($count/$limit);
        $data = $model
            ->orderBy('created_at', 'desc')
            ->offset($offset)
            ->limit($limit)
            ->get();
            
        return [
            'data' => $data,
            'pagesCount' => $pagesCount
        ];
    }

    public static function create($data){  
        return StatusPurchaseDirectory::create($data);
    }
    public static function card($id){ 
        return StatusPurchaseDirectory::find($id);
    }
    public static function update($id, $data){ 
        $model = StatusPurchaseDirectory::find($id);
        if(!$model) return null; 
        $model->updateOrFail($data);
        return $model;
    }
    public static function delete($id){ 
        $model = StatusPurchaseDirectory::find($id);
        if(!$model) return null; 
        return $model->update(['deleted_at' => now()]);
    }
    public static function recover($id){ 
        $model = StatusPurchaseDirectory::find($id);
        if(!$model) return null; 
        return $model->update(['deleted_at' => null]);
    }
}