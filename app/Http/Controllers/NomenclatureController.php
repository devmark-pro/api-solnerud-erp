<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Services\Nomenclature\NomenclatureService;


class NomenclatureController extends Controller
{

    public function index()
    {
        return NomenclatureService::index();
    }

    public function create(Request $request)
    {
        try {
            $data = $request->all();
            $validator = Validator::make($data, [
                'name'=>'required',
                'system_number' => 'unique:nomenclatures'
            ]);
 
            if($validator->fails()){
                $error = $validator->errors()->toArray();
                return response()->json($error)->setStatusCode(417); 
            }

            return NomenclatureService::create($data);
        } catch (Exception $e){
            return $e->getMessage();
        }
    }

    public function card(string $id)
    {
        $data = NomenclatureService::card($id);
        if(!$data) return response()->json(['error'=>'Not found'], 404);
        return $data; 
    }

    public function update(Request $request, string $id)
    {
        $data = $request->all();
        $validator = Validator::make($data, [
            'system_number' => 'unique:nomenclatures'
        ]);
 
        if($validator->fails()){
            $error = $validator->errors()->toArray();
            return response()->json($error)->setStatusCode(417); 
        }

        $result = NomenclatureService::update($id, $data);
        if(!$result) return response()->json(['error'=>'Not found'], 404);
        return $result;
    }

    public function destroy(string $id)
    {
        $data = NomenclatureService::delete($id);
        if(!$data) return response()->json(['error'=>'Not found'], 404);
        return $data;
    }

    public function recover(string $id)
    {
        $data = NomenclatureService::recover($id);
        if(!$data) return response()->json(['error'=>'Not found'], 404);
        return $data;
    }
}
