<?php
namespace App\Services\Purchase\Purchase;
use App\Models\Purchase\Purchase;

class PurchaseService
{
    public static function index($page = 1 ,$limit = 10 ) {

        $offset = $limit * ($page-1);
        $model = Purchase::where(['deleted_at'=> null]);
        $total = $model->get()->count();
        $pagesCount= ceil($total/$limit);
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
            ],
        ];
    }

    public static function create($data){  
        return Purchase::create($data);
    }
    public static function card($id){ 
        return Purchase::where(['id' => $id])
            ->with([
                'statusPurchase', 
                'purchaseType', 
                'counterparty', 
                'nomenclature', 
                'client',
                'packingType',
                'deliveryMethod',
                'deliveryAddress',
                'invoice',
                'accountSupplier',
                'receipts',
                'expenses',
                'document'
            ])->first();
    }
    public static function update($id, $data){ 
        $model = Purchase::find($id);
        if(!$model) return null; 
        $model->updateOrFail($data);
        return $model;
    }
    public static function delete($id){ 
        $model = Purchase::find($id);
        if(!$model) return null; 
        return $model->update(['deleted_at' => now()]);   
    }
    public static function recover($id){ 
        $model = Purchase::find($id);
        if(!$model) return null; 
        return $model->update(['deleted_at' => null]);
    }
}