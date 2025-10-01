<?php
namespace App\Services\Client\Client;
use App\Models\Client\Client;

class ClientService
{
    public static function index($requestAll) {
        try {
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
            $model = Client::where(['deleted_at' => null])
                ->with(['representatives']);

            $total = $model->get()->count();

            if(array_key_exists('find', $requestAll) 
                && (is_string($requestAll['find']))
            ) {

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
                'pagination' => [
                    'pagesCount' => $pagesCount,
                    'page' => $page,
                    'limit' => $limit,
                    'total' => $total,
                    'count' => $count,
                ],
                'data' => $data,

            ];
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public static function create($data){  
        try{
            return Client::create($data);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
     public static function card($id){ 
        return Client::where(['id' => $id])
            ->with(['representatives'])
            ->first();    
    }
    public static function update($id, $data){ 
        try {
            Client::where('id', $id)->update($data);
            return Client::where('id', $id)
            ->with(['representatives'])
            ->first();
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
    public static function delete($id){ 
        $model = Client::find($id);
        if(!$model) return null; 
        return $model->update(['deleted_at' => now()]); 
    }
    public static function recover($id){ 
        $model = Client::find($id);
        if(!$model) return null; 
        return $model->update(['deleted_at' => null]);
    }
}