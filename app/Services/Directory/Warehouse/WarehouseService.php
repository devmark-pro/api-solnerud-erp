<?php
namespace App\Services\Directory\Warehouse;
use App\Models\Directory\WarehouseDirectory;

class WarehouseService
{
    public static function index($page = 1 ,$limit = 100 ) {
        $offset = $limit * ($page-1);
        $model = WarehouseDirectory::where(['deleted_at'=> null])
            ->with(['user']);
        $count = $model->get()->count();
        $pagesCount= ceil($count/$limit);
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
                'count' => $count,
            ],
        ];
    }

    public static function create($data){  
        return WarehouseDirectory::create($data);
    }
    public static function card($id){ 
        return WarehouseDirectory::find($id);
    }
    public static function update($id, $data){ 
        $model = WarehouseDirectory::find($id);
        if(!$model) return null; 
        $model->updateOrFail($data);
        return $model;
    }
    public static function delete($id){ 
        $model = WarehouseDirectory::find($id);
        if(!$model) return null; 
        return $model->update(['deleted_at' => now()]); 
    }
    public static function recover($id){ 
        $model = WarehouseDirectory::find($id);
        if(!$model) return null; 
        return $model->update(['deleted_at' => null]);
    }
}