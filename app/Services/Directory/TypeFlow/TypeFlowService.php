<?php
namespace App\Services\Directory\TypeFlow;
use App\Models\Directory\TypeFlowDirectory;

class TypeFlowService
{

    public static function index() {
        return TypeFlowDirectory::where(['deleted_at'=> null])->get();
    }
    public static function create($data){  
        return TypeFlowDirectory::create($data);
    }
    public static function card($id){ 
        return TypeFlowDirectory::findOrFail($id);
    }
    public static function update($id, $data){ 
        return TypeFlowDirectory::findOrFail($id)->update($data);
    }
    public static function delete($id){ 
        return TypeFlowDirectory::findOrFail($id)->updateOrFail(['deleted_at' => now()]);
    }
    public static function recover($id){ 
        return TypeFlowDirectory::findOrFail($id)->updateOrFail(['deleted_at'=> null]);
    }

}