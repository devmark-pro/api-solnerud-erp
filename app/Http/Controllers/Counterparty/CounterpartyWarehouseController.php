<?php

namespace App\Http\Controllers\Counterparty;

use App\Http\Controllers\Controller;
use App\Models\Counterparty\CounterpartyWarehouse\CounterpartyWarehouse;
use App\Services\Counterparty\CounterpartyWarehouse\CounterpartyWarehouseService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class CounterpartyWarehouseController extends Controller
{
    public function index(Request $request)
    {
        $requestAll = $request->all();
        return CounterpartyWarehouseService::index($requestAll);
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
                return response()->json(['message'=>$error])->setStatusCode(417); 
            
            }
            return CounterpartyWarehouseService::create($data);
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
        $data = CounterpartyWarehouseService::card($id);
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
            $result = CounterpartyWarehouseService::update($id, $data);
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
        $data = CounterpartyWarehouseService::delete($id);
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
        $data = CounterpartyWarehouseService::recover($id);
        if(!$data) return response()->json(['message'=>'Not found'], 404);
        return $data;
    }
    public function field($id, $field)
    {   
        if(!(new CounterpartyWarehouse())->isFillable($field)) {
            return response()->json(['message'=>"Field $field not found"], 404);}
        $data = CounterpartyWarehouseService::field($id, $field);
        if(!$data) return response()->json(['message'=>'Not found'], 404);
        return $data;
    }
}
