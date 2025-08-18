<?php
namespace App\Services\Directory\EmployeeStatus;
use App\Models\Directory\EmployeeStatusDirectory;

class EmployeeStatusService
{

    public static function index() {
        return EmployeeStatusDirectory::where(['deleted_at'=> null])->get();
    }
    public static function create($data){  
        return EmployeeStatusDirectory::create($data);
    }
    public static function card($id){ 
        return EmployeeStatusDirectory::findOrFail($id);
    }
    public static function update($id, $data){ 
        return EmployeeStatusDirectory::findOrFail($id)->update($data);
    }
    public static function delete($id){ 
        return EmployeeStatusDirectory::findOrFail($id)->updateOrFail(['deleted_at' => now()]);
    }
    public static function recover($id){ 
        return EmployeeStatusDirectory::findOrFail($id)->updateOrFail(['deleted_at'=> null]);
    }

}