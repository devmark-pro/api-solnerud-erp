<?php

namespace App\Http\Controllers\Directory;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Directory\CounterpartyType\CounterpartyTypeService;


class CounterpartyTypeController extends Controller
{

    public function index()
    {
        return CounterpartyTypeService::index();
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

            return CounterpartyTypeService::create($data);
        } catch (Exception $e){
            return $e->getMessage();
        }
    }

    public function card(string $id)
    {
        return CounterpartyTypeService::card($id);
    }

    public function update(Request $request, string $id)
    {
        return CounterpartyTypeService::update($id, $request->all());
    }

    public function destroy(string $id)
    {
        return CounterpartyTypeService::delete($id);
    }

    public function recover(string $id)
    {
        return CounterpartyTypeService::recover($id);
    }
}
