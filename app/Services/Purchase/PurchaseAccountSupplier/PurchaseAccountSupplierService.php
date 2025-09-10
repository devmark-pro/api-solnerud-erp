<?php

namespace App\Services\Purchase\PurchaseAccountSupplier;

use App\Models\Purchase\PurchaseAccountSupplier;

class PurchaseAccountSupplierService
{
    public static function index($page = 1, $limit = 10 ) {
        $offset = $limit * ($page-1);
        $model = PurchaseAccountSupplier::where(['deleted_at'=> null]);
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
        return PurchaseAccountSupplier::create($data);
    }
    public static function card($id){ 
        return PurchaseAccountSupplier::where(['id'=>$id])
            ->with(['paymentType'])
            ->first();
    }
    public static function update($id, $data){ 
        $model = PurchaseAccountSupplier::find($id);
        if(!$model) return null; 
        $model->updateOrFail($data);
        return $model;
    }
    public static function delete($id){ 
        $model = PurchaseAccountSupplier::find($id);
        if(!$model) return null; 
        return $model->update(['deleted_at' => now()]);
    }
    public static function recover($id){ 
        $model = PurchaseAccountSupplier::find($id);
        if(!$model) return null; 
        return $model->update(['deleted_at' => null]);
    }

}