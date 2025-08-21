<?php

namespace App\Http\Controllers\Directory;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Directory\StatusPurchase\StatusPurchaseService;
use Illuminate\Support\Facades\Validator;


class StatusPurchaseController extends Controller
{

    public function index()
    {
        return StatusPurchaseService::index();
    }

    public function create(Request $request)
    {
        try {
            $data = $request->all();
            $validator = Validator::make($data, [
                'name'=>'required',
                'color'=>'required'
            ]);
 
            if($validator->fails()){
                $error = $validator->errors()->toArray();
                return response()->json($error)->setStatusCode(417); 
            }

            return StatusPurchaseService::create($data);
        } catch (Exception $e){
            return $e->getMessage();
        }
    }

public function card(string $id)
    {
        $data = StatusPurchaseService::card($id);
        if(!$data) return response()->json(['message'=>'Not found'], 404);
        return $data; 
    }

    public function update(Request $request, string $id)
    {
        $data = StatusPurchaseService::update($id, $request->all());
        if(!$data) return response()->json(['message'=>'Not found'], 404);
        return $data;
    }

    public function destroy(string $id)
    {
        $data = StatusPurchaseService::delete($id);
        if(!$data) return response()->json(['message'=>'Not found'], 404);
        return $data;
    }

    public function recover(string $id)
    {
        $data = StatusPurchaseService::recover($id);
        if(!$data) return response()->json(['message'=>'Not found'], 404);
        return $data;
    }
}
