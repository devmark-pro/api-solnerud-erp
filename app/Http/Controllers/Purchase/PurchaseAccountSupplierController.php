<?php

namespace App\Http\Controllers\Purchase;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Services\Purchase\PurchaseAccountSupplier\PurchaseAccountSupplierService;

class PurchaseAccountSupplierController extends Controller
{
    public function index(Request $request)
    { 
        $requestAll = $request->all();
        return PurchaseAccountSupplierService::index($requestAll);
    }

    public function create(Request $request)
    {
        try {
            $data = $request->all();
            $validator = Validator::make($data, [
                'payment_type_id'=>'required',
                'summ'=>'required',
                'purchase_id'=>'required',
            ]);
 
            if($validator->fails()){
                $error = $validator->errors()->toArray();
                return response()->json(['message'=>$error])->setStatusCode(417); 
            
            }

            return PurchaseAccountSupplierService::create($data);
        } catch (Exception $e){
            return $e->getMessage();
        }
    }

     public function card(Request $request)
    {
        $validator = Validator::make($request->all(), [
                'id'=>'required',
        ]);
        if($validator->fails()){
            $error = $validator->errors()->toArray();
            return response()->json(['message'=>$error])->setStatusCode(417);     
        }
        $id = $request->input('id');
        $data = PurchaseAccountSupplierService::card($id);
        if(!$data) return response()->json(['message'=>'Not found'], 404);
        return $data; 
    }

     public function update(Request $request)
    {
        try {
            $requestData=$request->all();
            $validator = Validator::make($requestData, [
                'id'=>'required',
                'data'=>'required',
            ]);
            if($validator->fails()){
                $error = $validator->errors()->toArray();
                return response()->json(['message'=>$error])->setStatusCode(417); 
            
            }
            $id = $request->input('id');
            $data = $request->input('data');
            $result = PurchaseAccountSupplierService::update($id, $data);
            if(!$result) return response()->json(['message'=>'Not found'], 404);
            return $result;
        } catch (Exception $e){
            return $e->getMessage();
        }
    }

    public function destroy(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id'=>'required',
        ]);

        if($validator->fails()){
            $error = $validator->errors()->toArray();
            return response()->json(['message'=>$error])->setStatusCode(417); 
        }
        $id = $request->input('id');
        $data = PurchaseAccountSupplierService::delete($id);
        if(!$data) return response()->json(['message'=>'Not found'], 404);
        return $data;
    }

    public function recover(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id'=>'required',
        ]);
        if($validator->fails()){
            $error = $validator->errors()->toArray();
            return response()->json(['message'=>$error])->setStatusCode(417); 
        }
        $id = $request->input('id');
        $data = PurchaseAccountSupplierService::recover($id);
        if(!$data) return response()->json(['message'=>'Not found'], 404);
        return $data;
    }
}
