<?php
namespace App\Services\Purchase;
use App\Models\Purchase;

class PurchaseService
{
    public static function index() {
        return Purchase::where(['deleted_at'=> null])->get();
    }
    public static function create($data){  
        return Purchase::create($data);
    }
    public static function card($id){ 
        $model = Purchase::find($id);
        if(!$model) return null;
        return $model->with([
                'statusPurchase', 
                'purchaseType', 
                'counterparty', 
                'nomenclature', 
                'client',
                'packingType',
                'deliveryMethod'
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
        $model->update(['deleted_at' => now()]);
        return $model; 
    }
    public static function recover($id){ 
        $model = Purchase::find($id);
        if(!$model) return null; 
        $model->update(['deleted_at' => null]);
        return $model; 
    }

}