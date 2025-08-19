<?php
namespace App\Services\Client;
use App\Models\Client;

class ClientService
{
    public static function index() {
        return Client::where(['deleted_at'=> null])->get();
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
        $model->update(['deleted_at' => now()]);
        return $model; 
    }
    public static function recover($id){ 
        $model = Client::find($id);
        if(!$model) return null; 
        $model->update(['deleted_at' => null]);
        return $model; 
    }

}