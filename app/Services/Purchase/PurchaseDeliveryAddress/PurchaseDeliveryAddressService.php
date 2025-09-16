<?php

namespace App\Services\Purchase\PurchaseDeliveryAddress;

use App\Models\Purchase\PurchaseDeliveryAddress;

class PurchaseDeliveryAddressService
{
    public static function index($page = 1 ,$limit = 10 ) {

        $offset = $limit * ($page-1);
        $model = PurchaseDeliveryAddress::where(['deleted_at'=> null]);
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
        return PurchaseDeliveryAddress::create($data);
    }
    public static function card($id){ 
        return PurchaseDeliveryAddress::find($id);
    }
    public static function update($id, $data){ 
        $model = PurchaseDeliveryAddress::find($id);
        if(!$model) return null; 
        $model->updateOrFail($data);
        return $model;
    }
    public static function delete($id){ 
        $model = PurchaseDeliveryAddress::find($id);
        if(!$model) return null; 
        return $model->update(['deleted_at' => now()]);
    }
    public static function recover($id){ 
        $model = PurchaseDeliveryAddress::find($id);
        if(!$model) return null; 
        return $model->update(['deleted_at' => null]);
    }
}