<?php
namespace App\Services\User;
use App\Models\User;

class UserService
{
    public static function index($page = 1 ,$limit = 10 ) {

        $offset = $limit * ($page-1);
        $model = User::where(['deleted_at'=> null]);
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
        User::create($data);
    }
    public static function card($id){ 
        return User::where(['id' => $id])->with([
                'employeePosition',
                'employeeStatus', 
                'warehouse'
            ])->first();    
    }
    public static function update($id, $data){ 
        $model = User::find($id);
        if(!$model) return null; 
        $model->updateOrFail($data);
        return $model;
    }
    public static function delete($id){ 
        $model = User::find($id);
        if(!$model) return null; 
        return $model->update(['deleted_at' => now()]);
    }
    public static function recover($id){ 
        $model = User::find($id);
        if(!$model) return null; 
        return $model->update(['deleted_at' => null]);
    }

}