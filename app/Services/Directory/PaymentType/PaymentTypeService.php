<?php
namespace App\Services\Directory\PaymentType;
use App\Models\Directory\PaymentTypeDirectory;

class PaymentTypeService
{

    public static function index() {
        return PaymentTypeDirectory::where(['deleted_at'=> null])->get();
    }
    public static function create($data){  
        return PaymentTypeDirectory::create($data);
    }
    public static function card($id){ 
        return PaymentTypeDirectory::findOrFail($id);
    }
    public static function update($id, $data){ 
        return PaymentTypeDirectory::findOrFail($id)->update($data);
    }
    public static function delete($id){ 
        return PaymentTypeDirectory::findOrFail($id)->updateOrFail(['deleted_at' => now()]);
    }
    public static function recover($id){ 
        return PaymentTypeDirectory::findOrFail($id)->updateOrFail(['deleted_at'=> null]);
    }

}