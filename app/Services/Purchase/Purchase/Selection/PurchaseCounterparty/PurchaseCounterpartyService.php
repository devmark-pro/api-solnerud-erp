<?php

namespace App\Services\Purchase\Purchase\Selection\PurchaseCounterparty;
use App\Models\Purchase\Purchase;

class PurchaseCounterpartyService
{
    private static function model() {
        
        return Purchase::join('counterparties', 
                    'counterparties.id', '=', 
                    'purchases.counterparty_id')
                ->with('counterparty')
                ->select('counterparty_id',
                    \DB::raw('
                        counterparty_id as id,
                        sum(count) as availability   
                    '))
                ->groupBy('counterparty_id')
                ->where('count', '>', 0);
                
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
            ->where('counterparty_id', $id)
            ->first();
       
    }


    private static function find($model, $requestAll) {
        if(array_key_exists('find', $requestAll) 
            && (is_string($requestAll['find']))
        ) {
            $find = $requestAll['find']; 
            $model
                ->where('counterparties.id', 'LIKE', "%$find%")
                ->orWhere('counterparties.name', 'ILIKE', "%$find%");       
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