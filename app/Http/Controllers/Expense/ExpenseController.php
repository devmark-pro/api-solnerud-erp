<?php

namespace App\Http\Controllers\Expense;

use App\Http\Controllers\Controller;
use App\Models\Expense\Expense;
use App\Services\Expense\Expense\ExpenseService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Gate;


class ExpenseController extends Controller
{
    public function index(Request $request)
    {
        if (!Gate::allows('expense_r')) {
            abort(403, "Не достаточно прав");
        }
        $requestAll = $request->all();
        return ExpenseService::index($requestAll);
    }

    public function create(Request $request)
    {
        try {
            if (!Gate::allows('expense_c')) {
                abort(403, "Не достаточно прав");
            }
            $data = $request->all();
            $validator = Validator::make($data, [
                'name'=>'required',
            ]);
 
            if($validator->fails()){
                $error = $validator->errors()->toArray();
                return response()->json(['message'=>$error])->setStatusCode(417); 
            
            }
            return ExpenseService::create($data);
        } catch (Exception $e){
            return $e->getMessage();
        }
    }

    public function card(Request $request)
    {
        if (!Gate::allows('expense_r')) {
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
        $data = ExpenseService::card($id);
        if(!$data) return response()->json(['message'=>'Not found'], 404);
        return $data; 
    }

    public function update(Request $request)
    {
        try {
            if (!Gate::allows('expense_u')) {
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
            $id = $request->input('id');
            $data = $request->input('data');
            $result = ExpenseService::update($id, $data);
            if(!$result) return response()->json(['message'=>'Not found'], 404);
            return $result;
        } catch (Exception $e){
            return $e->getMessage();
        }
    }

    public function destroy(Request $request)
    {
        if (!Gate::allows('expense_d')) {
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
        $data = ExpenseService::delete($id);
        if(!$data) return response()->json(['message'=>'Not found'], 404);
        return $data;
    }

    public function recover(Request $request)
    {
        if (!Gate::allows('expense_d')) {
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
        $data = ExpenseService::recover($id);
        if(!$data) return response()->json(['message'=>'Not found'], 404);
        return $data;
    }
    public function field($id, $field)
    {   
        if (!Gate::allows('expense_r')) {
            abort(403, "Не достаточно прав");
        }
        if(!(new Expense())->isFillable($field)) {
            return response()->json(['message'=>"Field $field not found"], 404);}
        $data = ExpenseService::field($id, $field);
        if(!$data) return response()->json(['message'=>'Not found'], 404);
        return $data;
    }
}
