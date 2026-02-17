<?php

namespace App\Services\Sale\SaleShipment\Selection\SaleShipmentProductSelection;
use App\Models\Sale\SaleProduct\SaleProduct;

class SaleShipmentProductSelectionService
{
    private static function model() {
        return SaleProduct::where([
            'sale_products.deleted_at' => null,
        ])
        ->leftJoin('sale_shipments', 
            'sale_products.id', '=', 
            'sale_shipments.sale_product_id')
        ->join('nomenclatures', 
            'sale_products.nomenclature_id', '=', 
            'nomenclatures.id')
        ->select(
            \DB::raw('
                sale_products.id as id,
                sale_products.nomenclature_id,
                sale_products.quantity,
                sum(sale_shipments.shipped_quantity) as shipped,
                (sale_products.quantity - shipped) as need
            '))
        ->groupBy('sale_products.id');
    }
    
    public static function index($requestAll) {

        try {
            
            $limit = 30;
            $filter = [];

            $model = self::model();
                // ->where('purchases.deleted_at', null);
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
            ->where('sale_products.id', $id)
            ->first();
    }

    private static function find($model, $requestAll) {
        if(array_key_exists('find', $requestAll) 
            && (is_string($requestAll['find']))
        ) {
            $find = $requestAll['find']; 
            $model->where(function ($query) use ($find) {
                $query
                    ->where('sale_products.id', 'LIKE', "%$find%")
                    ->orWhere('nomenclatures.name', 'ILIKE', "%$find%");       
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
            foreach($filter as $key => $item) {
                if(is_array($item)) {
                    if(count($item)) {
                        $model->whereIn('sale_products.'.$key, $item);
                    }
                } else {
                    $filter['sale_products.'.$key] = $item;
                }
                unset($filter[$key]);
            }

            $model->where($filter);
        }
        return $model;
    }
   
}