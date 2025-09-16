<?php
namespace App\Services\Directory\Warehouse;
use App\Models\Directory\WarehouseDirectory;

class WarehouseService
{
    public static function index($requestAll) {
        $page = 1;
        $limit = 10;
        if((array_key_exists('pagination', $requestAll)
            && (array_key_exists('page', $requestAll['pagination']))
            && (array_key_exists('limit', $requestAll['pagination']))    
        )){
            $page = $requestAll['pagination']['page'] ?? 1;
            $limit = $requestAll['pagination']['limit'] ?? 10;
        }
        

        $offset = $limit * ($page-1);

        $model = WarehouseDirectory::where(['deleted_at' => null])
            ->with(['user']);
        
        $total = $model->get()->count();

        if(array_key_exists('find', $requestAll)){
            $find = $requestAll['find'];
            $model->where('id', 'LIKE', "%$find%")
                ->orWhere('name', 'LIKE', "%$find%");
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