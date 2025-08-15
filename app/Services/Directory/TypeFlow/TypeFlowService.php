<?php
namespace App\Services\Directory\TypeFlow;
use App\Models\Directory\DirectoryTypeFlow;

class TypeFlowService
{

    public static function index() {
        return DirectoryTypeFlow::where(['deleted_at'=> null])->get();
    }
    public static function create($data){  
        return DirectoryTypeFlow::create($data);
    }
    public static function card($id){ 
        return DirectoryTypeFlow::findOrFail($id);
    }
    public static function update($id, $data){ 
        return DirectoryTypeFlow::findOrFail($id)->update($data);
    }
    public static function delete($id){ 
        return DirectoryTypeFlow::findOrFail($id)->updateOrFail(['deleted_at' => now()]);
    }
    public static function recover($id){ 
        return DirectoryTypeFlow::findOrFail($id)->updateOrFail(['deleted_at'=> null]);
    }

}