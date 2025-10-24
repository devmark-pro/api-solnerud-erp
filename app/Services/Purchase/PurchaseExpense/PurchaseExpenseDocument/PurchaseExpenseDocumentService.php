<?php

namespace App\Services\Purchase\PurchaseExpense\PurchaseExpenseDocument;
use App\Models\Purchase\PurchaseExpense\PurchaseExpenseDocument;

class PurchaseExpenseDocumentService
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
            $model = PurchaseExpenseDocument::where(['deleted_at' => null]);
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
            return PurchaseExpenseDocument::create($data);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public static function updateOrCreateInArray($purchaseExpenseId, $purchaseId, $documents){
        try {
            foreach ($documents as $doc) {
                $doc['purchase_id'] = $purchaseId;
                $doc['purchase_expense_id'] = $purchaseExpenseId;
                if(array_key_exists('id', $doc)){
                    PurchaseExpenseDocument::where(["id" => $doc['id']])
                        ->update($doc);
                }else{
                    PurchaseExpenseDocument::create($doc);
                }
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public static function card($id){ 
        return PurchaseExpenseDocument::where(['id' => $id])
            ->first();    
    }
    public static function update($id, $data){ 
        try {
            PurchaseExpenseDocument::where('id', $id)->update($data);
            return PurchaseExpenseDocument::where('id', $id)
                ->first();

        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
    public static function delete($id){ 
        try {
            return PurchaseExpenseDocument::where('id', $id)->update(['deleted_at' => now()]);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
    public static function recover($id){ 
        try {
            return PurchaseExpenseDocument::where('id', $id)->update(['deleted_at' => null]);
        } catch (Exception $e) {
            return $e->getMessage();
        }
     }
}