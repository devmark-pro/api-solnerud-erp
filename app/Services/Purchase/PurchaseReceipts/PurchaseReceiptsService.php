<?php

namespace App\Services\Purchase\PurchaseReceipt;

use App\Models\Purchase\PurchaseReceipt;

class PurchaseReceiptService
{
    public static function index($page = 1 ,$limit = 100 ) {
        $offset = $limit * ($page-1);
        $model = PurchaseReceipt::where(['deleted_at'=> null]);
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
                'count' => $count,
            ],
        ];
    }
    public static function create($data){  
        return PurchaseReceipt::create($data);
    }
    public static function card($id){ 
        return PurchaseReceipt::where(['id'=>$id])
            ->with(['user', 'warehouse'])
            ->first();
    }
    public static function update($id, $data){ 
        $model = PurchaseReceipt::find($id);
        if(!$model) return null; 
        $model->updateOrFail($data);
        return $model;
    }
    public static function delete($id){ 
        $model = PurchaseReceipt::find($id);
        if(!$model) return null; 
        return $model->update(['deleted_at' => now()]);
    }
    public static function recover($id){ 
        $model = PurchaseReceipt::find($id);
        if(!$model) return null; 
        return $model->update(['deleted_at' => null]);
    }

}