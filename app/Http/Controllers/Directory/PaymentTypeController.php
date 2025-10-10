<?php

namespace App\Http\Controllers\Directory;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Directory\PaymentType\PaymentTypeService;


class PaymentTypeController extends Controller
{
    public function index(Request $request)
    {
        $page = $request->get('page') ?? 1;
        $limit = $request->get('limit') ?? 100;
        return PaymentTypeService::index($page, $limit);
    }

    public function create(Request $request)
    {
        try {
            $updateData = $request->all();
            $validator = Validator::make($updateData, [
                'name'=>'required|unique:directory_payment_types',
                'color'=>'required',
            ]);
 
            if($validator->fails()){
                $error = $validator->errors()->toArray();
               return response()->json(['message'=>$error])->setStatusCode(417); 
            
            }

            return PaymentTypeService::create($updateData);
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
            $data = PaymentTypeService::card($id);
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
                // 'data.name'=>'required|unique:directory_payment_types',
            ]);
            if($validator->fails()){
                $error = $validator->errors()->toArray();
                return response()->json(['message'=>$error])->setStatusCode(417); 
            
            }
            $validator = Validator::make($requestData['data'], [
                'name'=>'required|unique:directory_payment_types,name,'.$requestData['id'],
            ]);
            if($validator->fails()){
                $error = $validator->errors()->toArray();
                return response()->json(['message'=>$error])->setStatusCode(417); 
            }
            $id = $request->input('id');
            $data = $request->input('data');
            $result = PaymentTypeService::update($id, $data);
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
            $data = PaymentTypeService::delete($id);
            if(!$data) return response()->json(['message'=>'Not found'], 404);
            return $data;
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
            $data = PaymentTypeService::recover($id);
            if(!$data) return response()->json(['message'=>'Not found'], 404);
            return $data;
        } catch (Exception $e){
            return $e->getMessage();
        }
    }
}