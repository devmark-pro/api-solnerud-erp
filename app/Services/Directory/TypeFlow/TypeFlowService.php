<?php
namespace App\Services\Directory\TypeFlow;
use App\Models\Directory\TypeFlowDirectory;

class TypeFlowService
{

    public static function index($page = 1 ,$limit = 100 ) {

        $offset = $limit * ($page-1);
        $model = TypeFlowDirectory::where(['deleted_at'=> null]);
        $count = $model->get()->count();
        $pagesCount= ceil($count/$limit);
        $data = $model
            ->orderBy('created_at', 'desc')
            ->offset($offset)
            ->limit($limit)
            ->get();
            
        return [
            'data' => $data,
            'pagesCount' => $pagesCount
        ];
    }
    public static function create($data){  
        return TypeFlowDirectory::create($data);
    }
    public static function card($id){ 
        return TypeFlowDirectory::find($id);
    }
    public static function update($id, $data){ 
        $model = TypeFlowDirectory::find($id);
        if(!$model) return null; 
        $model->updateOrFail($data);
        return $model;
    }
    public static function delete($id){ 
        $model = TypeFlowDirectory::find($id);
        if(!$model) return null; 
        return $model->update(['deleted_at' => now()]); 
    }
    public static function recover($id){ 
        $model = TypeFlowDirectory::find($id);
        if(!$model) return null; 
        return $model->update(['deleted_at' => null]);
    }
}