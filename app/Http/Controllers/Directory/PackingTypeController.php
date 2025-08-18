<?php

namespace App\Http\Controllers\Directory;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Directory\PackingType\PackingTypeService;


class PackingTypeController extends Controller
{

    public function index()
    {
        return PackingTypeService::index();
    }

    public function create(Request $request)
    {
        try {
            $data = $request->all();
            $validator = Validator::make($data, [
                'name'=>'required',
            ]);
 
            if($validator->fails()){
                $error = $validator->errors()->toArray();
                return response()->json($error)->setStatusCode(417); 
            }

            return PackingTypeService::create($data);
        } catch (Exception $e){
            return $e->getMessage();
        }
    }

    public function card(string $id)
    {
        return PackingTypeService::card($id);
    }

    public function update(Request $request, string $id)
    {
        return PackingTypeService::update($id, $request->all());
    }

    public function destroy(string $id)
    {
        return PackingTypeService::delete($id);
    }

    public function recover(string $id)
    {
        return PackingTypeService::recover($id);
    }
}
