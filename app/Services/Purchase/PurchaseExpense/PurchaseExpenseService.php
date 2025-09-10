<?php

namespace App\Services\Purchase\PurchaseExpense;

use App\Models\Purchase\PurchaseExpense;

class PurchaseExpenseService
{
    public static function index($page = 1 ,$limit = 100 ) {
        $offset = $limit * ($page-1);
        $model = PurchaseExpense::where(['deleted_at'=> null]);
        $count = $model->get()->count();
        $pagesCount= ceil($count/$limit);
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
                'count' => $count,
            ],
        ];
    }
    public static function create($data){  
        return PurchaseExpense::create($data);
    }
    public static function card($id){ 
        return PurchaseExpense::where(['id'=>$id])
            ->with(['address'])
            ->first();
    }
    public static function update($id, $data){ 
        $model = PurchaseExpense::find($id);
        if(!$model) return null; 
        $model->updateOrFail($data);
        return $model;
    }
    public static function delete($id){ 
        $model = PurchaseExpense::find($id);
        if(!$model) return null; 
        return $model->update(['deleted_at' => now()]);
    }
    public static function recover($id){ 
        $model = PurchaseExpense::find($id);
        if(!$model) return null; 
        return $model->update(['deleted_at' => null]);
    }

}