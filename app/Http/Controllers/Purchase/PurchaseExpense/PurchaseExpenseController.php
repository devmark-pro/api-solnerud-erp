<?php
namespace App\Http\Controllers\Purchase\PurchaseExpense;

use App\Http\Controllers\Controller;
use App\Services\Purchase\PurchaseExpense\PurchaseExpenseService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Gate;

class PurchaseExpenseController extends Controller
{
    public function index(Request $request)
    {
        // if (!Gate::allows('purchase_r')) {
        //     abort(403,"Не достаточно прав");
        // }
        $requestAll = $request->all();
        return PurchaseExpenseService::index($requestAll);
    }

    public function create(Request $request)
    {
        try {
            if (!Gate::allows('purchase_u')) {
                abort(403,"Не достаточно прав");
            }
            $data = $request->all();
            $validator = Validator::make($data, [
                'purchase_address_ids' => 'required', 
                'executor_type' => 'required',
                'include_in_cost' => 'required',
                'purchase_id' => 'required',
                'reimbursement_expenses' => 'in:refunded,required,not_required'
            ]);
 
            if($validator->fails()){
                $error = $validator->errors()->toArray();
                return response()->json(['message'=>$error])->setStatusCode(417); 
            }

            return PurchaseExpenseService::create($data);
        } catch (Exception $e){
            return $e->getMessage();
        }
    }

 public function card(Request $request)
    {
        if (!Gate::allows('purchase_r')) {
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
        $data = PurchaseExpenseService::card($id);
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
            $result = PurchaseExpenseService::update($id, $data);
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
        $data = PurchaseExpenseService::delete($id);
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
        $data = PurchaseExpenseService::recover($id);
        if(!$data) return response()->json(['message'=>'Not found'], 404);
        return $data;
    }
}
