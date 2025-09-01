<?php

namespace App\Services\Purchase\PurchaseInvoice;

use App\Models\Purchase\PurchaseInvoice;

class PurchaseInvoiceService
{
    public static function index($page = 1 ,$limit = 100 ) {
        $offset = $limit * ($page-1);
        $model = PurchaseInvoice::where(['deleted_at'=> null]);
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
        return PurchaseInvoice::create($data);
    }
    public static function card($id){ 
        return PurchaseInvoice::where(['id'=>$id])
            ->with(['user'])
            ->first();
    }
    public static function update($id, $data){ 
        $model = PurchaseInvoice::find($id);
        if(!$model) return null; 
        $model->updateOrFail($data);
        return $model;
    }
    public static function delete($id){ 
        $model = PurchaseInvoice::find($id);
        if(!$model) return null; 
        return $model->update(['deleted_at' => now()]);
    }
    public static function recover($id){ 
        $model = PurchaseInvoice::find($id);
        if(!$model) return null; 
        return $model->update(['deleted_at' => null]);
    }

}