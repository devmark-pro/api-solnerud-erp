<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Nomenclature\NomenclatureService;


class NomenclatureController extends Controller
{

    public function index(Request $request)
    {
        $requestAll = $request->all();
        return NomenclatureService::index($requestAll);
    }

    public function create(Request $request)
    {
        try {
            $requestData = $request->all();
            $validator = Validator::make($requestData, [
                'system_number'=>'required|unique:nomenclatures',
                'name'=>'required',
            ]);
 
            if($validator->fails()){
                $error = $validator->errors()->toArray();
                return response()->json(['message'=>$error])->setStatusCode(417); 
            
            }

            return NomenclatureService::create($requestData);
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
            $data = NomenclatureService::card($id);
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
                // 'data.name'=>'required|unique:directory_Nomenclatures',
            ]);
            if($validator->fails()){
                $error = $validator->errors()->toArray();
                return response()->json(['message'=>$error])->setStatusCode(417); 
            
            }
            // $validator = Validator::make($requestData['data'], [
            //     'name'=>'required|unique:directory_Nomenclatures,name,'.$requestData['id'],
            // ]);
            if($validator->fails()){
                $error = $validator->errors()->toArray();
                return response()->json(['message'=>$error])->setStatusCode(417); 
            }
            $id = $request->input('id');
            $data = $request->input('data');
            $result = NomenclatureService::update($id, $data);
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
            $data = NomenclatureService::delete($id);
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
            $data = NomenclatureService::recover($id);
            if(!$data) return response()->json(['message'=>'Not found'], 404);
            return $data;
        } catch (Exception $e){
            return $e->getMessage();
        }
    }
}
