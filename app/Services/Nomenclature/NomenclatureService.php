<?php
namespace App\Services\Nomenclature;
use App\Models\Nomenclature;

class NomenclatureService
{
    public static function index($requestAll) {
        try {
            $page = 1;
            $limit = 10;
            if((array_key_exists('pagination', $requestAll)
                && (array_key_exists('page', $requestAll['pagination']))
                && (array_key_exists('limit', $requestAll['pagination']))    
            )){
                $page = $requestAll['pagination']['page'] ?? 1;
                $limit = $requestAll['pagination']['limit'] ?? 10;
            }
            
            $offset = $limit * ($page-1);
            $model = Nomenclature::where(['deleted_at' => null]);
            $total = $model->get()->count();

            if(array_key_exists('find', $requestAll) 
                && (is_string($requestAll['find']))
            ) {

                $find = $requestAll['find']; 
                $model->where('system_number', 'LIKE', "%$find%")
                    ->orWhere('name', 'ILIKE', "%$find%");
            }
            $count = $model->where(['deleted_at' => null])->get()->count();

            $pagesCount = ceil($count/$limit);

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
                    'total' => $total,
                    'count' => $count,
                ],
            ];
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public static function create($data){  
        try{
            return Nomenclature::create($data);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
    public static function card($id){ 
        return Nomenclature::find($id);
    }
    public static function update($id, $data){ 
        try {
            Nomenclature::where('id', $id)->update($data);
            return Nomenclature::where('id', $id)->first();
        } catch (Exception $e) {
            return $e->getMessage();
        }
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