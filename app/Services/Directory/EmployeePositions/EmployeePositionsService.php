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
    public static function update($id, $data){ 
        $model = EmployeePositionsDirectory::find($id);
        if(!$model) return null; 
        $model->updateOrFail($data);
        return $model;
    }
    public static function delete($id){ 
        $model = EmployeePositionsDirectory::find($id);
        if(!$model) return null; 
        $model->update(['deleted_at' => now()]);
        return $model; 
    }
    public static function recover($id){ 
        $model = EmployeePositionsDirectory::find($id);
        if(!$model) return null; 
        $model->update(['deleted_at' => null]);
        return $model; 
    }
}