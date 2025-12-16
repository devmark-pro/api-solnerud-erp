<?php

namespace App\Http\Controllers\Sale\SaleExpense;

use App\Http\Controllers\Controller;
use App\Models\Sale\SaleExpense\SaleExpense\SaleExpense;
use App\Services\Sale\SaleExpense\SaleExpense\SaleExpenseService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class SaleExpenseController extends Controller
{
    public function index(Request $request)
    {
        $requestAll = $request->all();
        return SaleExpenseService::index($requestAll);
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
            return SaleExpenseService::create($data);
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
        $data = SaleExpenseService::card($id);
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
            $result = SaleExpenseService::update($id, $data);
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
        $data = SaleExpenseService::delete($id);
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
        $data = SaleExpenseService::recover($id);
        if(!$data) return response()->json(['message'=>'Not found'], 404);
        return $data;
    }
    public function field($id, $field)
    {   
        if(!(new SaleExpense())->isFillable($field)) {
            return response()->json(['message'=>"Field $field not found"], 404);}
        $data = SaleExpenseService::field($id, $field);
        if(!$data) return response()->json(['message'=>'Not found'], 404);
        return $data;
    }
}
