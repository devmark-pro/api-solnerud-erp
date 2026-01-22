<?php

namespace App\Http\Controllers\Purchase\PurchaseExpense;

use App\Http\Controllers\Controller;
use App\Services\Purchase\PurchaseExpense\PurchaseExpenseDocument\PurchaseExpenseDocumentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Purchase\PurchaseExpense\PurchaseExpenseDocument;
use Illuminate\Support\Facades\Gate;


class PurchaseExpenseDocumentController extends Controller
{
    public function index(Request $request)
    {
        if (!Gate::allows('purchase_r')) {
            abort(403,"Не достаточно прав");
        }
        $requestAll = $request->all();
        return PurchaseExpenseDocumentService::index($requestAll);
    }

    public function create(Request $request)
    {
        try {
            if (!Gate::allows('purchase_u')) {
                abort(403,"Не достаточно прав");
            }
            $data = $request->all();
            $validator = Validator::make($data, [
                'name'=>'required',
                'file'=>'required',
                'purchase_id'=>'required',
                'purchase_expense_id'=>'required',
            ]);
 
            if($validator->fails()){
                $error = $validator->errors()->toArray();
                return response()->json(['message'=>$error])->setStatusCode(417); 
            
            }
            return PurchaseExpenseDocumentService::create($data);
        } catch (Exception $e){
            return $e->getMessage();
        }
    }

    public function card(Request $request)
    {
        if (!Gate::allows('purchase_u')) {
            abort(403,"Не достаточно прав");
        }
        $validator = Validator::make($request->all(), [
            'id'=>'required',
        ]);
        if($validator->fails()){
            $error = $validator->errors()->toArray();
            return response()->json(['message'=>$error])->setStatusCode(417);     
        }
        $id = $request->input('id');
        $data = PurchaseExpenseDocumentService::card($id);
        if(!$data) return response()->json(['message'=>'Not found'], 404);
        return $data; 
    }

    public function update(Request $request)
    {
        try {
            if (!Gate::allows('purchase_u')) {
                abort(403,"Не достаточно прав");
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
            $result = PurchaseExpenseDocumentService::update($id, $data);
            if(!$result) return response()->json(['message'=>'Not found'], 404);
            return $result;
        } catch (Exception $e){
            return $e->getMessage();
        }
    }

    public function destroy(Request $request)
    {
        if (!Gate::allows('purchase_u')) {
            abort(403,"Не достаточно прав");
        }
        $validator = Validator::make($request->all(), [
            'id'=>'required',
        ]);
        if($validator->fails()){
            $error = $validator->errors()->toArray();
            return response()->json(['message'=>$error])->setStatusCode(417); 
        }
        $id = $request->input('id');
        $data = PurchaseExpenseDocumentService::delete($id);
        if(!$data) return response()->json(['message'=>'Not found'], 404);
        return $data;
    }

    public function recover(Request $request)
    {
        if (!Gate::allows('purchase_u')) {
            abort(403,"Не достаточно прав");
        }
        $validator = Validator::make($request->all(), [
            'id'=>'required',
        ]);
        if($validator->fails()){
            $error = $validator->errors()->toArray();
            return response()->json(['message'=>$error])->setStatusCode(417); 
        }
        $id = $request->input('id');
        $data = PurchaseExpenseDocumentService::recover($id);
        if(!$data) return response()->json(['message'=>'Not found'], 404);
        return $data;
    }

    public function field($id, $field)
    {   
        if (!Gate::allows('purchase_u')) {
            abort(403,"Не достаточно прав");
        }
        if(!(new PurchaseExpenseDocument())->isFillable($field)) {
            return response()->json(['message'=>"Field $field not found"], 404);}
        $data = PurchaseExpenseDocumentService::field($id, $field);
        if(!$data) return response()->json(['message'=>'Not found'], 404);
        return $data;
    }
}
