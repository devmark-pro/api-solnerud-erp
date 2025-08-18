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
        return NomenclatureService::card($id);
    }

    public function update(Request $request, string $id)
    {
        return NomenclatureService::update($id, $request->all());
    }

    public function destroy(string $id)
    {
        return NomenclatureService::delete($id);
    }

    public function recover(string $id)
    {
        return NomenclatureService::recover($id);
    }
}
