<?php
namespace App\Services\Directory\DeliveryMethod;
use App\Models\Directory\DeliveryMethodDirectory;

class DeliveryMethodService
{

    public static function index($page = 1 ,$limit = 10 ) {

        $offset = $limit * ($page-1);
        $model = DeliveryMethodDirectory::where(['deleted_at'=> null]);
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
        return DeliveryMethodDirectory::create($data);
    }
    public static function card($id){ 
        return DeliveryMethodDirectory::find($id);
    }
    public static function update($id, $data){ 
          try {
            DeliveryMethodDirectory::where('id', $id)->update($data);
            return DeliveryMethodDirectory::where('id', $id)->first();

        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
    public static function delete($id){ 
        $model = DeliveryMethodDirectory::find($id);
        if(!$model) return null; 
        return $model->update(['deleted_at' => now()]);  
    }
    public static function recover($id){ 
        $model = DeliveryMethodDirectory::find($id);
        if(!$model) return null; 
        return $model->update(['deleted_at' => null]);
    }
}