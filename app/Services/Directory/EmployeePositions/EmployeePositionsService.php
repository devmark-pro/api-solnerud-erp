<?php
namespace App\Services\Directory\EmployeePositions;
use App\Models\Directory\EmployeePositionDirectory;

class EmployeePositionsService
{

    public static function index() {
        return EmployeePositionDirectory::where(['deleted_at'=> null])->get();
    }
    public static function create($data){  
        return EmployeePositionDirectory::create($data);
    }
    public static function card($id){ 
        return EmployeePositionDirectory::find($id);
    }
    public static function update($id, $data){ 
        $model = EmployeePositionDirectory::find($id);
        if(!$model) return null; 
        $model->updateOrFail($data);
        return $model;
    }
    public static function delete($id){ 
        $model = EmployeePositionDirectory::find($id);
        if(!$model) return null; 
        return $model->update(['deleted_at' => now()]);      
    }
    public static function recover($id){ 
        $model = EmployeePositionDirectory::find($id);
        if(!$model) return null; 
        return $model->update(['deleted_at' => null]);
    }
}