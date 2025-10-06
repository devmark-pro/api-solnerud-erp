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

    public function card(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'id'=>'required',
            ]);
            if($validator->fails()){
                $error = $validator->errors()->toArray();
               return response()->json(['message'=>$error])->setStatusCode(417); 
            
            }
            $id = $request->input('id');
            $data = PurchaseService::card($id);
            if(!$data) return response()->json(['message'=>'Not found'], 404);
            return $data; 
        } catch (Exception $e){
            return $e->getMessage();
        }
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
        
            if($validator->fails()){
                $error = $validator->errors()->toArray();
                return response()->json(['message'=>$error])->setStatusCode(417); 
            }
            $id = $request->input('id');
            $data = $request->input('data');
            $result = PurchaseService::update($id, $data);
            if(!$result) return response()->json(['message'=>'Not found'], 404);
            return $result;
        } catch (Exception $e){
            return $e->getMessage();
        }
    }

    public function destroy(Request $request)
    {
         try {
            $validator = Validator::make($request->all(), [
                'id'=>'required',
            ]);
            if($validator->fails()){
                $error = $validator->errors()->toArray();
               return response()->json(['message'=>$error])->setStatusCode(417); 
            
            }
            $id = $request->input('id');
            $result = PurchaseService::delete($id);
            if(!$result) return response()->json(['message'=>'Not found'], 404);
            return $result;
        } catch (Exception $e){
            return $e->getMessage();
        }
    }

    public function recover(Request $request)
    {

        try {
            $validator = Validator::make($request->all(), [
                'id'=>'required',
            ]);
            if($validator->fails()){
                $error = $validator->errors()->toArray();
               return response()->json(['message'=>$error])->setStatusCode(417); 
            
            }
            $id = $request->input('id');
            $data = PurchaseService::recover($id);
            if(!$data) return response()->json(['message'=>'Not found'], 404);
            return $data;
        } catch (Exception $e){
            return $e->getMessage();
        }
    }
}
