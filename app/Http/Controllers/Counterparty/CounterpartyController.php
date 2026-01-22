<?php

namespace App\Http\Controllers\Counterparty;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Counterparty\Counterparty\CounterpartyService;
use Illuminate\Support\Facades\Gate;

class CounterpartyController extends Controller
{

    public function index(Request $request)
    {
        // if (!Gate::allows('counterparty_r')) {
        //         abort(403, "Не достаточно прав");
        // }
        $requestAll = $request->all();
        return CounterpartyService::index($requestAll);
    }

    public function create(Request $request)
    {
        try {
            if (!Gate::allows('counterparty_c')) {
                abort(403, "Не достаточно прав");
        }
            $requestData = $request->all();
            $validator = Validator::make($requestData, [
                'name'=>'required',
            ]);
 
            if($validator->fails()){
                $error = $validator->errors()->toArray();
                return response()->json(['message'=>$error])->setStatusCode(417); 
            
            }

            return CounterpartyService::create($requestData);
        } catch (Exception $e){
            return $e->getMessage();
        }
    }

    public function card(Request $request)
    {
        try {
            if (!Gate::allows('counterparty_r')) {
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
            $data = CounterpartyService::card($id);
            if(!$data) return response()->json(['message'=>'Not found'], 404);
            return $data; 

        } catch (Exception $e){
            return $e->getMessage();
        }
    }

    public function update(Request $request)
    {
        try {
            if (!Gate::allows('counterparty_u')) {
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
                'inn'=>'required|unique:counterparties',
            ]);

            if($validatorData->fails()){
                $error = $validatorData->errors()->toArray();
                return response()->json(['message'=>$error])->setStatusCode(417); 
            }
            
            $id = $request->input('id');
            $data = $request->input('data');
            $result = CounterpartyService::update($id, $data);
            if(!$result) return response()->json(['message'=>'Not found'], 404);
            return $result;
        } catch (Exception $e){
            return $e->getMessage();
        }
    }

    public function destroy(Request $request)
    {
        try {
            if (!Gate::allows('counterparty_d')) {
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
            $data = CounterpartyService::delete($id);
            if(!$data) return response()->json(['message'=>'Not found'], 404);
            return $data;
        } catch (Exception $e){
            return $e->getMessage();
        }
    }

    public function recover(Request $request)
    {   
        try {
            if (!Gate::allows('counterparty_r')) {
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
            $data = CounterpartyService::recover($id);
            if(!$data) return response()->json(['message'=>'Not found'], 404);
            return $data;
        } catch (Exception $e){
            return $e->getMessage();
        }
    }
}
