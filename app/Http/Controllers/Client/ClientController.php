<?php

namespace App\Http\Controllers\Client;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Client\Client\ClientService;
use Illuminate\Support\Facades\Gate;


class ClientController extends Controller
{

    public function index(Request $request)
    {
        if (!Gate::allows('client_r')) {
            abort(403, "Не достаточно прав");
        }
        $requestAll = $request->all();
        return ClientService::index($requestAll);
    }

    public function create(Request $request)
    {
        try {
            if (!Gate::allows('client_c')) {
                abort(403, "Не достаточно прав");
            }
            $requestData = $request->all();
            $validator = Validator::make($requestData, [
                'name'=>'required',
                'inn'=>'required|unique:clients',

            ]);
 
            if($validator->fails()){
                $error = $validator->errors()->toArray();
                return response()->json(['message'=>$error])->setStatusCode(417); 
            
            }

            return ClientService::create($requestData);
        } catch (Exception $e){
            return $e->getMessage();
        }
    }

    public function card(Request $request)
    {
        try {
            if (!Gate::allows('client_r')) {
                abort(403, "Не достаточно прав");
            }
            $validator = Validator::make($request->all(), [
                'id'=>'required',
            ]);
            if($validator->fails()){
                $error = $validator->errors()->toArray();
               return response()->json(['message'=>$error])->setStatusCode(417); 
            
            }
            $id = $request->input('id');
            $data = ClientService::card($id);
            if(!$data) return response()->json(['message'=>'Not found'], 404);
            return $data; 

        } catch (Exception $e){
            return $e->getMessage();
        }
    }

    public function update(Request $request)
    {
        try {
            if (!Gate::allows('client_u')) {
                abort(403, "Не достаточно прав");
            }
            $requestData=$request->all();
            $validator = Validator::make($requestData, [
                'id'=>'required',
                'data'=>'required',
            ]);


            if($validator->fails()){
                $error = $validator->errors()->toArray();
                return response()->json(['message'=>$error])->setStatusCode(417); 
            
            }
            $validatorData = Validator::make($requestData['data'], [
                'inn'=>'required|unique:clients',
            ]);
            if($validatorData->fails()){
                $error = $validatorData->errors()->toArray();
                return response()->json(['message'=>$error])->setStatusCode(417); 
            }
            $id = $request->input('id');
            $data = $request->input('data');
            $result = ClientService::update($id, $data);
            if(!$result) return response()->json(['message'=>'Not found'], 404);
            return $result;
        } catch (Exception $e){
            return $e->getMessage();
        }
    }

    public function destroy(Request $request)
    {
        try {
            if (!Gate::allows('client_d')) {
                abort(403, "Не достаточно прав");
            }
            $validator = Validator::make($request->all(), [
                'id'=>'required',
            ]);
            if($validator->fails()){
                $error = $validator->errors()->toArray();
               return response()->json(['message'=>$error])->setStatusCode(417); 
            
            }
            $id = $request->input('id');
            $data = ClientService::delete($id);
            if(!$data) return response()->json(['message'=>'Not found'], 404);
            return $data;
        } catch (Exception $e){
            return $e->getMessage();
        }
    }

    public function recover(Request $request)
    {   
        try {
            if (!Gate::allows('client_d')) {
                abort(403, "Не достаточно прав");
            }
            $validator = Validator::make($request->all(), [
                'id'=>'required',
            ]);
            if($validator->fails()){
                $error = $validator->errors()->toArray();
               return response()->json(['message'=>$error])->setStatusCode(417); 
            
            }
            $id = $request->input('id');
            $data = ClientService::recover($id);
            if(!$data) return response()->json(['message'=>'Not found'], 404);
            return $data;
        } catch (Exception $e){
            return $e->getMessage();
        }
    }
}
