<?php
namespace App\Services\Counterparty;
use App\Models\Counterparty;

class CounterpartyService
{
    public static function index() {
        return Counterparty::where(['deleted_at'=> null])->get();
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
        $model->update(['deleted_at' => now()]);
        return $model; 
    }
    public static function recover($id){ 
        $model = Counterparty::find($id);
        if(!$model) return null; 
        $model->update(['deleted_at' => null]);
        return $model; 
    }
}