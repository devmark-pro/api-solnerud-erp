<?php
namespace App\Services\Directory\EmployeePositions;
use App\Models\Directory\DirectoryEmployeePositions;

class EmployeePositionsService
{

    public static function index() {
        return DirectoryEmployeePositions::where(['deleted_at'=> null])->get();
    }
    public static function create($data){  
        return DirectoryEmployeePositions::create($data);
    }
    public static function card($id){ 
        return DirectoryEmployeePositions::findOrFail($id);
    }
    public static function update($id, $data){ 
        return DirectoryEmployeePositions::findOrFail($id)->update($data);
    }
    public static function delete($id){ 
        return DirectoryEmployeePositions::findOrFail($id)->updateOrFail(['deleted_at' => now()]);
    }
    public static function recover($id){ 
        return DirectoryEmployeePositions::findOrFail($id)->updateOrFail(['deleted_at'=> null]);
    }

}