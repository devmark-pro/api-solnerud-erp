<?php

namespace App\Services\Purchase\Purchase\Selection\PurchaseNomenclature;
use App\Models\Purchase\Purchase;

class PurchaseNomenclatureService
{
    private static function model(){
        return Purchase::join('nomenclatures', 
                'nomenclatures.id', '=', 
                'purchases.nomenclature_id')
            ->with('nomenclature')
            ->select('nomenclature_id',
                \DB::raw('
                    nomenclature_id as id,    
                    sum(count) as availability   
                '))
            ->groupBy('nomenclature_id');   
    }
    
    public static function index($requestAll) {

        try {
            
            $limit = 30;
            $filter = [];

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
            ->where('nomenclature_id', $id)
            ->first();
    }

    private static function find($model, $requestAll) {
        if(array_key_exists('find', $requestAll) 
            && (is_string($requestAll['find']))
        ) {
            $find = $requestAll['find']; 
            $model
                ->where('nomenclatures.id', 'LIKE', "%$find%")
                ->orWhere('nomenclatures.name', 'ILIKE', "%$find%");       
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