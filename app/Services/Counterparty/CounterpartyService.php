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
        return Counterparty::findOrFail($id);
    }
    public static function update($id, $data){ 
        return Counterparty::findOrFail($id)->update($data);
    }
    public static function delete($id){ 
        return Counterparty::findOrFail($id)->updateOrFail(['deleted_at' => now()]);
    }
    public static function recover($id){ 
        return Counterparty::findOrFail($id)->updateOrFail(['deleted_at'=> null]);
    }

}