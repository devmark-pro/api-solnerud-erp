<?php
namespace App\Services\Directory\PurchaseType;

use App\Models\Directory\PurchaseTypeDirectory;

class PurchaseTypeService
{

    public static function index($page = 1 ,$limit = 100 ) {

        $offset = $limit * ($page-1);
        $model = PurchaseTypeDirectory::where(['deleted_at'=> null]);
        $count = $model->get()->count();
        $pagesCount= ceil($count/$limit);
        $data = $model
            ->orderBy('created_at', 'asc')
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
        return PurchaseTypeDirectory::create($data);
    }
    public static function card($id){ 
        return PurchaseTypeDirectory::find($id);
    }
    public static function update($id, $data){ 
        $model = PurchaseTypeDirectory::find($id);
        if(!$model) return null; 
        $model->updateOrFail($data);
        return $model;
    }
    public static function delete($id){ 
        $model = PurchaseTypeDirectory::find($id);
        if(!$model) return null; 
        return $model->update(['deleted_at' => now()]);
        
    }
    public static function recover($id){ 
        $model = PurchaseTypeDirectory::find($id);
        if(!$model) return null; 
        return $model->update(['deleted_at' => null]);
    }
}