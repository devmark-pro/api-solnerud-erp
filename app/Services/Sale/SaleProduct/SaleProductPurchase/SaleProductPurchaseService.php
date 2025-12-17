<?php

namespace App\Services\Sale\SaleProduct\SaleProductPurchase;
use App\Models\Sale\SaleProduct\SaleProductPurchase;
use Illuminate\Support\Facades\Log;


class SaleProductPurchaseService
{
     public static function index($requestAll) {
        try {
            $page = 1;
            $limit = 10;
            $filter=[];
            if((array_key_exists('pagination', $requestAll)
                && (array_key_exists('page', $requestAll['pagination']))
                && (array_key_exists('limit', $requestAll['pagination']))    
            )){
                $page = $requestAll['pagination']['page'] ?? 1;
                $limit = $requestAll['pagination']['limit'] ?? 10;
            }
            
            $offset = $limit * ($page-1);
            $model = SaleProductPurchase::where(['deleted_at' => null]);
               // ->with([])
            
            $total = $model->get()->count();

            if(array_key_exists('find', $requestAll) 
                && (is_string($requestAll['find']))
            ) {

                $find = $requestAll['find']; 
                $model->where('id', 'LIKE', "%$find%")
                    ->orWhere('name', 'LIKE', "%$find%");
            }

            if(array_key_exists('filter', $requestAll) 
               && (is_array($requestAll['filter']))
            ) 
            {
                $filter = $requestAll['filter']; 
                $model->where($filter);
            }
            
            $count = $model->where(['deleted_at' => null])->get()->count();

            $pagesCount = ceil($count/$limit);

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
                    'count' => $count,
                ],
            ];
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
     
    public static function create($data){
        try {
            return SaleProductPurchase::create($data);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
    public static function card($id){ 
        return SaleProductPurchase::where(['id' => $id])
            //->with([])
            ->first();    
    }
    public static function update($id, $data){ 
        try {
            SaleProductPurchase::where('id', $id)->first()->update($data);
            return SaleProductPurchase::where('id', $id)
                //->with([])
                ->first();

        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
    public static function delete($id){ 
        try {
            return SaleProductPurchase::where('id', $id)->update(['deleted_at' => now()]);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
    public static function recover($id){ 
        try {
            return SaleProductPurchase::where('id', $id)->update(['deleted_at' => null]);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
    public static function field($id, $field){ 
        try {
            $result = SaleProductPurchase::where('id', $id)->select($field)->first();
            if(!$result ) return;
            return $result[$field];
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public static function deleteAndCreateArray($saleProductId, $saleId, $shipmentType, $data){
        try {
            SaleProductPurchase::where([
                'sale_id' => $saleId,
                'sale_product_id' => $saleProductId
            ])->delete();

            foreach ($data as $key => $list) {
                foreach ($list as $item) {
                    SaleProductPurchase::create([
                        'sale_id' => $saleId,
                        'sale_product_id' => $saleProductId,
                        'shipment_type' => $shipmentType,
                        $key => $item
                        ]
                    );
                }
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}