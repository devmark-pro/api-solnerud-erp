<?php

namespace App\Services\Sale\SaleExpense\SaleExpenseProduct;
use App\Models\Sale\SaleExpense\SaleExpenseProduct;

class SaleExpenseProductService
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
            $model = SaleExpenseProduct::where(['deleted_at' => null]);
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
            return SaleExpenseProduct::create($data);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
    public static function card($id){ 
        return SaleExpenseProduct::where(['id' => $id])
            //->with([])
            ->first();    
    }
    public static function update($id, $data){ 
        try {
            SaleExpenseProduct::where('id', $id)->first()->update($data);
            return SaleExpenseProduct::where('id', $id)
                //->with([])
                ->first();

        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
    public static function delete($id){ 
        try {
            return SaleExpenseProduct::where('id', $id)->update(['deleted_at' => now()]);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
    public static function recover($id){ 
        try {
            return SaleExpenseProduct::where('id', $id)->update(['deleted_at' => null]);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
    public static function field($id, $field){ 
        try {
            $result = SaleExpenseProduct::where('id', $id)->select($field)->first();
            if(!$result ) return;
            return $result[$field];
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public static function updateOrCreateInArray($saleExpenseId, $saleId, $list){
        try {
            foreach ($list as $item) {
                $item['sale_id'] = $saleId;
                $item['sale_expense_id'] = $saleExpenseId;
                if(array_key_exists('id', $item)){
                    SaleExpenseProduct::where(["id" => $item['id']])
                        ->update($item);
                }else{
                    SaleExpenseProduct::create($item);
                }
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}