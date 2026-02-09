<?php

namespace App\Services\Purchase\Purchase\Selection\PurchaseDeliveryMethod;
use App\Models\Purchase\Purchase;

class PurchaseDeliveryMethodService
{

    private static function model(){
        return Purchase::join('directory_delivery_methods', 
                'directory_delivery_methods.id', '=', 
                'purchases.delivery_method_id')
            ->with('deliveryMethod')
            ->select('delivery_method_id',
                \DB::raw('
                    delivery_method_id as id,    
                    sum(count) as availability   
                '))
            ->groupBy('delivery_method_id');   
    }
    
    public static function index($requestAll) {

        try {
            
            $limit = 30;
           
            $model = self::model();
            $model = self::find($model, $requestAll);
            $model = self::filter($model, $requestAll);

            $data = $model->limit($limit)->get();

            return [
                'data' => $data,
            ];

        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public static function card($id, $requestAll) { 

        $model = self::model();
        $model = self::filter($model, $requestAll);
        return $model
            ->where('delivery_method_id', $id)
            ->first();
    }

    private static function find($model, $requestAll) {
        if(array_key_exists('find', $requestAll) 
            && (is_string($requestAll['find']))
        ) {
            $find = $requestAll['find']; 
            $model->where(function ($query) use ($find) {
                $query
                    ->where('directory_delivery_methods.id', 'LIKE', "%$find%")
                    ->orWhere('directory_delivery_methods.name', 'ILIKE', "%$find%");    
            });        
            
        }
        return $model;
    }

    private static function filter($model, $requestAll){
        if(array_key_exists('filter', $requestAll) 
            && (is_array($requestAll['filter']))
        )
        {
            $filter = $requestAll['filter'];

            foreach($filter as $key => $item){
                if(is_array($item)) {
                    if(count($item)) {
                        $model->whereIn($key, $item);
                    }
                unset($filter[$key]);
                }
            }

            $model->where($filter);
        }
        return $model;
    }
   
}