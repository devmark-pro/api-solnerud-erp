<?php
namespace App\Services\Warehouse;
use App\Models\Warehouse;

class WarehouseService
{
    public static function index($requestAll) {
        try {

            $page = 1;
            $limit = 100;
            if((array_key_exists('pagination', $requestAll)
                && (array_key_exists('page', $requestAll['pagination']))
                && (array_key_exists('limit', $requestAll['pagination']))    
            )){
                $page = $requestAll['pagination']['page'] ?? 1;
                $limit = $requestAll['pagination']['limit'] ?? 10;
            }
            

            $offset = $limit * ($page-1);

            $model = Warehouse::where(['deleted_at' => null])
                ->with(['user']);
            
            $total = $model->get()->count();

            if(array_key_exists('find', $requestAll) 
                && (is_string($requestAll['find']))
            ) {

                $find = $requestAll['find']; 
                $model->where('id', 'LIKE', "%$find%")
                    ->orWhere('name', 'ILIKE', "%$find%");
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
        try{
            return Warehouse::create($data);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
    public static function card($id){ 
        return Warehouse::find($id);
    }
    public static function update($id, $data){ 
        try {
            Warehouse::where('id', $id)->update($data);
            return Warehouse::where('id', $id)->with([
                'user', 
            ])->first();
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
    public static function delete($id){ 
        $model = Warehouse::find($id);
        if(!$model) return null; 
        return $model->update(['deleted_at' => now()]); 
    }
    public static function recover($id){ 
        $model = Warehouse::find($id);
        if(!$model) return null; 
        return $model->update(['deleted_at' => null]);
    }
}