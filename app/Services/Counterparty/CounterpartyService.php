<?php
namespace App\Services\Counterparty;
use App\Models\Counterparty;

class CounterpartyService
{
    public static function index($page = 1 ,$limit = 10 ) {

        $offset = $limit * ($page-1);
        $model = Counterparty::where(['deleted_at'=> null]);
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
        return Counterparty::create($data);
    }
    public static function card($id){ 
        $model = Counterparty::find($id);
        if(!$model) return null;
        return $model->with('counterpartyType')->first();
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