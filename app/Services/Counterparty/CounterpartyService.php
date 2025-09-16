<?php
namespace App\Services\Counterparty;
use App\Models\Counterparty;

class CounterpartyService
{
    public static function index($page = 1 ,$limit = 10 ) {

        $offset = $limit * ($page-1);
        $model = Counterparty::where(['deleted_at'=> null]);
        $total = $model->get()->count();
        $pagesCount= ceil($total/$limit);
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
            ],];
    }
     
    public static function create($data){  
        return Counterparty::create($data);
    }
    public static function card($id){ 
        return Counterparty::where(['id'=>$id])
            ->with('counterpartyType')
            ->first();
    }
    public static function update($id, $data){ 
        $model = Counterparty::find($id);
        if(!$model) return null; 
        $model->updateOrFail($data);
        return $model;
    }
    public static function delete($id){ 
        $model = Counterparty::find($id);
        if(!$model) return null; 
        return $model->update(['deleted_at' => now()]); 
    }
    public static function recover($id){ 
        $model = Counterparty::find($id);
        if(!$model) return null; 
        return $model->update(['deleted_at' => null]);
    }
}