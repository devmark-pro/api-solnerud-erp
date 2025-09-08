<?php

namespace App\Http\Controllers\Purchase;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Purchase\Purchase\PurchaseService;


class PurchaseController extends Controller
{

    public function index(Request $request)
    {
        $page = $request->get('page') ?? 1;
        $limit = $request->get('limit') ?? 10;
        return PurchaseService::index($page, $limit);
    }

    public function create(Request $request)
    {
        try {
            $data = $request->all();
            $validator = Validator::make($data, [
                'counterparty_id'=>'required',
                'nomenclature_id'=>'required',
                'client_id'=>'required', 
                'delivery_method_id'=>'required',
                'price'=>'required', 
                'count_plan'=>'required',
            ]);
 
            if($validator->fails()){
                $error = $validator->errors()->toArray();
               return response()->json(['message'=>$error])->setStatusCode(417); 
            
            }

            return PurchaseService::create($data);
        } catch (Exception $e){
            return $e->getMessage();
        }
    }

    public function card(string $id)
    {
        $data = PurchaseService::card($id);
        if(!$data) return response()->json(['message'=>'Not found'], 404);
        return $data; 
    }

    public function update(Request $request, string $id)
    {
        $data = PurchaseService::update($id, $request->all());
        if(!$data) return response()->json(['message'=>'Not found'], 404);
        return $data;
    }

    public function destroy(string $id)
    {
        $data = PurchaseService::delete($id);
        if(!$data) return response()->json(['message'=>'Not found'], 404);
        return $data;
    }

    public function recover(string $id)
    {
        $data = PurchaseService::recover($id);
        if(!$data) return response()->json(['message'=>'Not found'], 404);
        return $data;
    }
}
