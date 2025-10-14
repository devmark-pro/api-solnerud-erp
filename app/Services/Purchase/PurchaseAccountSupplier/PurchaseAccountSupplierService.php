<?php

namespace App\Services\Purchase\PurchaseAccountSupplier;
use App\Models\Purchase\PurchaseAccountSupplier;

class PurchaseAccountSupplierService
{
     public static function index($requestAll) {
        try {
            $page = 1;
            $limit = 10;
            $filter = [];
            if((array_key_exists('pagination', $requestAll)
                && (array_key_exists('page', $requestAll['pagination']))
                && (array_key_exists('limit', $requestAll['pagination']))    
            )){
                $page = $requestAll['pagination']['page'] ?? 1;
                $limit = $requestAll['pagination']['limit'] ?? 10;
            }
            
            $offset = $limit * ($page-1);
            $model = PurchaseAccountSupplier::where(['deleted_at' => null])
                ->with(['paymentType']);
            
            $total = $model->get()->count();

            if(array_key_exists('find', $requestAll) 
                && (is_string($requestAll['find']))
            ) {

                $find = $requestAll['find']; 
                $model->where('id', 'LIKE', "%$find%")
                    ->orWhere('name', 'ILIKE', "%$find%");
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
                'pagination' => [
                    'pagesCount' => $pagesCount,
                    'page' => $page,
                    'limit' => $limit,
                    'total' => $total,
                    'count' => $count,
                ],
                'data_total' => [
                    'summ' => PurchaseAccountSupplier::where(['deleted_at' => null])
                        ->where($filter)->sum('summ'),
                    'summ_nds' => PurchaseAccountSupplier::where(['deleted_at' => null])
                        ->where($filter)->sum('summ_nds'),
                    'paid' => PurchaseAccountSupplier::where(['deleted_at' => null])
                        ->where($filter)->sum('paid'),
                    'remained' => -1
                ],
                'data' => $data,
            ];
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
     
    public static function create($data){
        try {
            return PurchaseAccountSupplier::create($data);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
    public static function card($id){ 
        return PurchaseAccountSupplier::where(['id' => $id])
            ->with(['paymentType'])
            ->first();    
    }
    public static function update($id, $data){ 
        try {
            PurchaseAccountSupplier::where('id', $id)->update($data);
            return PurchaseAccountSupplier::where('id', $id)
                ->with(['paymentType'])
                ->first();

        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
    public static function delete($id){ 
        try {
            return PurchaseAccountSupplier::where('id', $id)->update(['deleted_at' => now()]);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
    public static function recover($id){ 
        try {
            return PurchaseAccountSupplier::where('id', $id)->update(['deleted_at' => null]);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}