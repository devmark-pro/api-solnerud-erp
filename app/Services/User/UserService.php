<?php
namespace App\Services\User;
use App\Models\User;

class UserService
{
    public static function index() {
        return User::where(['deleted_at'=> null])->get();
    }
    public static function create($data){
        // try {
            User::create($data);
        // }catch (Exception $e) {
        //     throw new Exception($e->getMessage());
        // }
    }
    public static function card($id){ 
        $model = User::find($id);
        if(!$model) return null;
        return $model->with([
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