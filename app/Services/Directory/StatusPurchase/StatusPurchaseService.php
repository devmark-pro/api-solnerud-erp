<?php
namespace App\Services\Directory\StatusPurchase;

use App\Models\Directory\StatusPurchaseDirectory;

class StatusPurchaseService
{

    public static function index($page = 1 ,$limit = 100 ) {

        $offset = $limit * ($page-1);
        $model = StatusPurchaseDirectory::where(['deleted_at'=> null]);
        $total = $model->get()->count();
        $pagesCount= ceil($total/$limit);
        $data = $model
            ->orderBy('created_at', 'asc')
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
        return StatusPurchaseDirectory::create($data);
    }
    public static function card($id){ 
        return StatusPurchaseDirectory::find($id);
    }
    public static function update($id, $data){ 
        try {
            StatusPurchaseDirectory::where('id', $id)->update($data);
            return StatusPurchaseDirectory::where('id', $id)->first();

        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
    public static function delete($id){ 
        $model = StatusPurchaseDirectory::find($id);
        if(!$model) return null; 
        return $model->update(['deleted_at' => now()]);
    }
    public static function recover($id){ 
        $model = StatusPurchaseDirectory::find($id);
        if(!$model) return null; 
        return $model->update(['deleted_at' => null]);
    }
}