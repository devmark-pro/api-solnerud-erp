<?php

namespace App\Services\Purchase\PurchaseExpense\PurchaseExpenseAddress;
use App\Models\Purchase\PurchaseExpense\PurchaseExpenseAddress;

class PurchaseExpenseAddressService
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
            $model = PurchaseExpenseAddress::where(['deleted_at' => null])
                ->with('address');
            
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
            return PurchaseExpenseAddress::create($data);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public static function updateOrCreateInArray($purchaseExpenseId, $purchaseId, $addresses){
        try {
            foreach ($addresses as $item) { 
                $updateData = [
                    'address_id' => $item['address_id'],
                    'purchase_id' => $purchaseId,
                    'purchase_expense_id' => $purchaseExpenseId,
                ];
                if(array_key_exists('id', $item)){
                    PurchaseExpenseAddress::where(["id" => $item['id']])
                        ->update($updateData);
                } else {
                    PurchaseExpenseAddress::create($updateData);
                }
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public static function card($id){ 
        return PurchaseExpenseAddress::where(['id' => $id])
            ->with('address')
            ->first();    
    }
    public static function update($id, $data){ 
        try {
            PurchaseExpenseAddress::where('id', $id)->update($data);
            return PurchaseExpenseAddress::where('id', $id)
                ->first();

        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
    public static function delete($id){ 
        try {
            return PurchaseExpenseAddress::where('id', $id)->update(['deleted_at' => now()]);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
    public static function recover($id){ 
        try {
            return PurchaseExpenseAddress::where('id', $id)->update(['deleted_at' => null]);
        } catch (Exception $e) {
            return $e->getMessage();
        }
     }
}