<?php
namespace App\Services\Directory\PositionRepresentative;
use App\Models\Directory\PositionRepresentativeDirectory;

class PositionRepresentativeService
{

    public static function index() {
        return PositionRepresentativeDirectory::where(['deleted_at'=> null])->get();
    }
    public static function create($data){  
        return PositionRepresentativeDirectory::create($data);
    }
    public static function card($id){ 
        return PositionRepresentativeDirectory::findOrFail($id);
    }
    public static function update($id, $data){ 
        return PositionRepresentativeDirectory::findOrFail($id)->update($data);
    }
    public static function delete($id){ 
        return PositionRepresentativeDirectory::findOrFail($id)->updateOrFail(['deleted_at' => now()]);
    }
    public static function recover($id){ 
        return PositionRepresentativeDirectory::findOrFail($id)->updateOrFail(['deleted_at'=> null]);
    }

}