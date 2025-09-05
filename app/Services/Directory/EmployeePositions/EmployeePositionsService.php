<?php
namespace App\Services\Directory\EmployeePositions;
use App\Models\Directory\EmployeePositionDirectory;

class EmployeePositionsService
{

    public static function index($page = 1 ,$limit = 10 ) {

        $offset = $limit * ($page-1);
        $model = EmployeePositionDirectory::where(['deleted_at'=> null]);
        $count = $model->get()->count();
        $pagesCount= ceil($count/$limit);
        $data = $model
            ->orderBy('created_at', 'asc')
            ->offset($offset)
            ->limit($limit)
            ->get();
            
        return [
            'data' => $data,
            'pagination' => [
                'pagesCount' => $pagesCount,
                'page' => $page,
                'limit' => $limit,
            ],
        ];
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