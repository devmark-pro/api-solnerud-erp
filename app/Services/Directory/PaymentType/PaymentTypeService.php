<?php
namespace App\Services\Directory\PaymentType;
use App\Models\Directory\DirectoryPaymentType;

class PaymentTypeService
{

    public static function index() {
        return DirectoryPaymentType::where(['deleted_at'=> null])->get();
    }
    public static function create($data){  
        return DirectoryPaymentType::create($data);
    }
    public static function card($id){ 
        return DirectoryPaymentType::findOrFail($id);
    }
    public static function update($id, $data){ 
        return DirectoryPaymentType::findOrFail($id)->update($data);
    }
    public static function delete($id){ 
        return DirectoryPaymentType::findOrFail($id)->updateOrFail(['deleted_at' => now()]);
    }
    public static function recover($id){ 
        return DirectoryPaymentType::findOrFail($id)->updateOrFail(['deleted_at'=> null]);
    }

}