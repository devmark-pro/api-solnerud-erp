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
        return Client::findOrFail($id);
    }
    public static function update($id, $data){ 
        return Client::findOrFail($id)->update($data);
    }
    public static function delete($id){ 
        return Client::findOrFail($id)->updateOrFail(['deleted_at' => now()]);
    }
    public static function recover($id){ 
        return Client::findOrFail($id)->updateOrFail(['deleted_at'=> null]);
    }

}