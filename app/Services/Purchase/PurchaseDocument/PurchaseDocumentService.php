<?php

namespace App\Services\Purchase\PurchaseDocument;

use App\Models\Purchase\PurchaseDocument;

class PurchaseDocumentService
{
    public static function index($page = 1 ,$limit = 100 ) {
        $offset = $limit * ($page-1);
        $model = PurchaseDocument::where(['deleted_at'=> null]);
        $total = $model->get()->count();
        $pagesCount= ceil($total/$limit);
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
                'total' => $total,
            ],
        ];
    }
    public static function create($data){  
        return PurchaseDocument::create($data);
    }
    public static function card($id){ 
        return PurchaseDocument::where(['id'=>$id])
            //->with(['user'])
            ->first();
    }
    public static function update($id, $data){ 
        $model = PurchaseDocument::find($id);
        if(!$model) return null; 
        $model->updateOrFail($data);
        return $model;
    }
    public static function delete($id){ 
        $model = PurchaseDocument::find($id);
        if(!$model) return null; 
        return $model->update(['deleted_at' => now()]);
    }
    public static function recover($id){ 
        $model = PurchaseDocument::find($id);
        if(!$model) return null; 
        return $model->update(['deleted_at' => null]);
    }

}