<?php

namespace App\Http\Controllers\Purchase;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Services\Purchase\PurchaseReceipt\PurchaseReceiptService;
use App\Models\Purchase\PurchaseReceipt;


class PurchaseReceiptsController extends Controller
{

    public function index(Request $request)
    {
        $requestAll = $request->all();
        return PurchaseReceiptService::index($requestAll);
    }

    public function create(Request $request)
    {
        try {
            $data = $request->all();
            $validator = Validator::make($data, [
                'purchase_id' => 'required',
                'quantity' => 'required',
            ]);
 
            if($validator->fails()){
                $error = $validator->errors()->toArray();
                return response()->json(['message'=>$error])->setStatusCode(417); 
            
            }

            return PurchaseReceiptService::create($data);
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
        $data = PurchaseReceiptService::card($id);
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
            $result = PurchaseReceiptService::update($id, $data);
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
        $data = PurchaseReceiptService::delete($id);
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
        $data = PurchaseReceiptService::recover($id);
        if(!$data) return response()->json(['message'=>'Not found'], 404);
        return $data;
    }
    
    public function field($id, $field)
    {   
        if(!(new PurchaseReceipt())->isFillable($field)) {
            return response()->json(['message'=>"Field $field not found"], 404);}
        $data = PurchaseReceiptService::field($id, $field);
        if(!$data) return response()->json(['message'=>'Not found'], 404);
        return $data;
    }
}
