<?php
namespace App\Services\Client;
use App\Models\Client;

class ClientService
{
    public static function index($page = 1 ,$limit = 10 ) {

        $offset = $limit * ($page-1);
        $model = Client::where(['deleted_at'=> null]);
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
            ],
        ];
    }
    public static function create($data){  
        return Client::create($data);
    }
    public static function card($id){ 
        return Client::find($id);
    }
    public static function update($id, $data){ 
        $model = Client::find($id);
        if(!$model) return null; 
        $model->updateOrFail($data);
        return $model;
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