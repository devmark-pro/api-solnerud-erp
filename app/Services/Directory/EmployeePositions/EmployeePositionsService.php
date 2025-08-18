<?php
namespace App\Services\Directory\EmployeePositions;
use App\Models\Directory\EmployeePositionsDirectory;

class EmployeePositionsService
{

    public static function index() {
        return EmployeePositionsDirectory::where(['deleted_at'=> null])->get();
    }
    public static function create($data){  
        return EmployeePositionsDirectory::create($data);
    }
    public static function card($id){ 
        return EmployeePositionsDirectory::findOrFail($id);
    }
    public static function update($id, $data){ 
        return EmployeePositionsDirectory::findOrFail($id)->update($data);
    }
    public static function delete($id){ 
        return EmployeePositionsDirectory::findOrFail($id)->updateOrFail(['deleted_at' => now()]);
    }
    public static function recover($id){ 
        return EmployeePositionsDirectory::findOrFail($id)->updateOrFail(['deleted_at'=> null]);
    }

}