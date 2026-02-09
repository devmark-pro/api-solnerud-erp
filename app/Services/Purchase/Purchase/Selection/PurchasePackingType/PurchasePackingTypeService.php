<?php

namespace App\Services\Purchase\Purchase\Selection\PurchasePackingType;
use App\Models\Purchase\Purchase;

class PurchasePackingTypeService
{

    private static function model(){
        return Purchase::join('directory_packing_types', 
                'directory_packing_types.id', '=', 
                'purchases.packing_type_id')
            ->with('packingType')
            ->select('packing_type_id',
                \DB::raw('
                    packing_type_id as id,    
                    sum(count) as availability   
                '))
            ->groupBy('packing_type_id');   
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
            ->where('packing_type_id', $id)
            ->first();
    }

    private static function find($model, $requestAll) {
        if(array_key_exists('find', $requestAll) 
            && (is_string($requestAll['find']))
        ) {
            $find = $requestAll['find']; 
            $model
                ->where('directory_packing_types.id', 'LIKE', "%$find%")
                ->orWhere('directory_packing_types.name', 'ILIKE', "%$find%");       
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