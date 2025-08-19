<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Services\Purchase\PurchaseService;


class PurchaseController extends Controller
{

    public function index()
    {
        return PurchaseService::index();
    }

    public function create(Request $request)
    {
        try {
            $data = $request->all();
            // $validator = Validator::make($data, [
            //     'name'=>'required',
            // ]);
 
            // if($validator->fails()){
            //     $error = $validator->errors()->toArray();
            //     return response()->json($error)->setStatusCode(417); 
            // }

            return PurchaseService::create($data);
        } catch (Exception $e){
            return $e->getMessage();
        }
    }

    public function card(string $id)
    {
        $data = PurchaseService::card($id);
        if(!$data) return response()->json(['error'=>'Not found'], 404);
        return $data; 
    }

    public function update(Request $request, string $id)
    {
        $data = PurchaseService::update($id, $request->all());
        if(!$data) return response()->json(['error'=>'Not found'], 404);
        return $data;
    }

    public function destroy(string $id)
    {
        $data = PurchaseService::delete($id);
        if(!$data) return response()->json(['error'=>'Not found'], 404);
        return $data;
    }

    public function recover(string $id)
    {
        $data = PurchaseService::recover($id);
        if(!$data) return response()->json(['error'=>'Not found'], 404);
        return $data;
    }
}
