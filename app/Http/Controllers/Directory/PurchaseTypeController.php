<?php

namespace App\Http\Controllers\Directory;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Directory\PurchaseType\PurchaseTypeService;


class PurchaseTypeController extends Controller
{

    public function index()
    {
        return PurchaseTypeService::index();
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

            return PurchaseTypeService::create($data);
        } catch (Exception $e){
            return $e->getMessage();
        }
    }

    public function card(string $id)
    {
        return PurchaseTypeService::card($id);
    }

    public function update(Request $request, string $id)
    {
        return PurchaseTypeService::update($id, $request->all());
    }

    public function destroy(string $id)
    {
        return PurchaseTypeService::delete($id);
    }

    public function recover(string $id)
    {
        return PurchaseTypeService::recover($id);
    }
}
