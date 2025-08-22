<?php
namespace App\Services\Directory\PositionRepresentative;
use App\Models\Directory\PositionRepresentativeDirectory;

class PositionRepresentativeService
{

    public static function index($page = 1 ,$limit = 10 ) {

        $offset = $limit * ($page-1);
        $model = PositionRepresentativeDirectory::where(['deleted_at'=> null]);
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
        return PositionRepresentativeDirectory::create($data);
    }
    public static function card($id){ 
        return PositionRepresentativeDirectory::find($id);
    }
    public static function update($id, $data){ 
        $model = PositionRepresentativeDirectory::find($id);
        if(!$model) return null; 
        $model->updateOrFail($data);
        return $model;
    }
    public static function delete($id){ 
        $model = PositionRepresentativeDirectory::find($id);
        if(!$model) return null; 
        return $model->update(['deleted_at' => now()]); 
    }
    public static function recover($id){ 
        $model = PositionRepresentativeDirectory::find($id);
        if(!$model) return null; 
        return $model->update(['deleted_at' => null]);
    }
}