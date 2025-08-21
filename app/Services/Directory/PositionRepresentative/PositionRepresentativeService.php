<?php
namespace App\Services\Directory\PositionRepresentative;
use App\Models\Directory\PositionRepresentativeDirectory;

class PositionRepresentativeService
{

    public static function index() {
        return PositionRepresentativeDirectory::where(['deleted_at'=> null])->get();
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