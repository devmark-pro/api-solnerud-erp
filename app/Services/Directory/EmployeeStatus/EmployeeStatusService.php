<?php
namespace App\Services\Directory\EmployeeStatus;
use App\Models\Directory\DirectoryEmployeeStatus;

class EmployeeStatusService
{

    public static function index() {
        return DirectoryEmployeeStatus::where(['deleted_at'=> null])->get();
    }
    public static function create($data){  
        return DirectoryEmployeeStatus::create($data);
    }
    public static function card($id){ 
        return DirectoryEmployeeStatus::findOrFail($id);
    }
    public static function update($id, $data){ 
        return DirectoryEmployeeStatus::findOrFail($id)->update($data);
    }
    public static function delete($id){ 
        return DirectoryEmployeeStatus::findOrFail($id)->updateOrFail(['deleted_at' => now()]);
    }
    public static function recover($id){ 
        return DirectoryEmployeeStatus::findOrFail($id)->updateOrFail(['deleted_at'=> null]);
    }

}