<?php
namespace App\Services\Directory\PositionRepresentative;
use App\Models\Directory\PositionRepresentativeDirectory;

class PositionRepresentativeService
{

    public static function index($page = 1 ,$limit = 10 ) {

        $offset = $limit * ($page-1);
        $model = PositionRepresentativeDirectory::where(['deleted_at'=> null]);
        $total = $model->get()->count();
        $pagesCount= ceil($total/$limit);
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
                'total' => $total,
            ],
        ];
    }

    public static function create($data){  
        return PositionRepresentativeDirectory::create($data);
    }
    public static function card($id){ 
        return PositionRepresentativeDirectory::find($id);
    }
    public static function update($id, $data){ 
          try {
            PositionRepresentativeDirectory::where('id', $id)->update($data);
            return PositionRepresentativeDirectory::where('id', $id)->first();

        } catch (Exception $e) {
            return $e->getMessage();
        }
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