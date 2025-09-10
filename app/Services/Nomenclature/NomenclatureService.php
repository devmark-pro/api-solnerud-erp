<?php
namespace App\Services\Nomenclature;
use App\Models\Nomenclature;

class NomenclatureService
{
    public static function index($page = 1 ,$limit = 10 ) {

        $offset = $limit * ($page-1);
        $model = Nomenclature::where(['deleted_at'=> null]);
        $count = $model->get()->count();
        $pagesCount= ceil($count/$limit);
        $data = $model
            ->orderBy('created_at', 'desc')
            ->offset($offset)
            ->limit($limit)
            ->get();
            
       return [
            'data' => $data,
            'pagination' => [
                'pagesCount' => $pagesCount,
                'page' => $page,
                'limit' => $limit,
                'count' => $count,
            ],
        ];
    }
     
    public static function create($data){  
        return Nomenclature::create($data);
    }
    public static function card($id){ 
        return Nomenclature::find($id);
    }
    public static function update($id, $data){ 
        $model = Nomenclature::find($id);
        if(!$model) return null; 
        $model->updateOrFail($data);
        return $model;
    }
    public static function delete($id){ 
        $model = Nomenclature::find($id);
        if(!$model) return null; 
        return $model->update(['deleted_at' => now()]);
    }
    public static function recover($id){ 
        $model = Nomenclature::find($id);
        if(!$model) return null; 
        return $model->update(['deleted_at' => null]);
    }
}