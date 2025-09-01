<?php
namespace App\Services\Directory\StatusSale;

use App\Models\Directory\StatusSaleDirectory;

class StatusSaleService
{

    public static function index($page = 1 ,$limit = 100 ) {

        $offset = $limit * ($page-1);
        $model = StatusSaleDirectory::where(['deleted_at'=> null]);
        $count = $model->get()->count();
        $pagesCount= ceil($count/$limit);
        $data = $model
            ->orderBy('created_at', 'desc')
            ->offset($offset)
            ->limit($limit)
            ->get();
            
        return [
            'data' => $data,
            'pagination' => [
                'pagesCount' => $pagesCount,
                'page' => $page,
                'limit' => $limit,
            ],
        ];
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
        return $model->update(['deleted_at' => now()]);
    }
    public static function recover($id){ 
        $model = StatusSaleDirectory::find($id);
        if(!$model) return null; 
        return $model->update(['deleted_at' => null]);
    }
}