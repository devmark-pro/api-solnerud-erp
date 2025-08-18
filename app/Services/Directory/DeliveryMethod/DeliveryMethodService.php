<?php
namespace App\Services\Directory\DeliveryMethod;
use App\Models\Directory\DeliveryMethodDirectory;

class DeliveryMethodService
{

    public static function index() {
        return DeliveryMethodDirectory::where(['deleted_at'=> null])->get();
    }
    public static function create($data){  
        return DeliveryMethodDirectory::create($data);
    }
    public static function card($id){ 
        return DeliveryMethodDirectory::findOrFail($id);
    }
    public static function update($id, $data){ 
        return DeliveryMethodDirectory::findOrFail($id)->update($data);
    }
    public static function delete($id){ 
        return DeliveryMethodDirectory::findOrFail($id)->updateOrFail(['deleted_at' => now()]);
    }
    public static function recover($id){ 
        return DeliveryMethodDirectory::findOrFail($id)->updateOrFail(['deleted_at'=> null]);
    }

}