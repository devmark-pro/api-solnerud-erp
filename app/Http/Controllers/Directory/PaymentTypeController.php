<?php

namespace App\Http\Controllers\Directory;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Directory\PaymentType\PaymentTypeService;


class PaymentTypeController extends Controller
{
    public function index()
    {
        return PaymentTypeService::index();
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

            return PaymentTypeService::create($data);
        } catch (Exception $e){
            return $e->getMessage();
        }
    }

    public function card(string $id)
    {
        $data = PaymentTypeService::card($id);
        if(!$data) return response()->json(['error'=>'Not found'], 404);
        return $data; 
    }

    public function update(Request $request, string $id)
    {
        $data = PaymentTypeService::update($id, $request->all());
        if(!$data) return response()->json(['error'=>'Not found'], 404);
        return $data;
    }

    public function destroy(string $id)
    {
        $data = PaymentTypeService::delete($id);
        if(!$data) return response()->json(['error'=>'Not found'], 404);
        return $data;
    }

    public function recover(string $id)
    {
        $data = PaymentTypeService::recover($id);
        if(!$data) return response()->json(['error'=>'Not found'], 404);
        return $data;
    }
}
