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
        return EmployeeStatusDirectory::find($id);
    }
    public static function update($id, $data){ 
        $model = EmployeeStatusDirectory::find($id);
        if(!$model) return null; 
        $model->updateOrFail($data);
        return $model;
    }
    public static function delete($id){ 
        $model = EmployeeStatusDirectory::find($id);
        if(!$model) return null; 
        return $model->update(['deleted_at' => now()]);   
    }
    public static function recover($id){ 
        $model = EmployeeStatusDirectory::find($id);
        if(!$model) return null; 
        return $model->update(['deleted_at' => null]);
    }
}