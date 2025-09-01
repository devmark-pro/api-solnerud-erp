<?php

namespace App\Http\Controllers\Purchase;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Services\Purchase\PurchaseAccountSupplier\PurchaseAccountSupplierService;

class PurchaseAccountSupplierController extends Controller
{
    public function index(Request $request)
    {
        
        $page = $request->get('page') ?? 1;
        $limit = $request->get('limit') ?? 10;
        return PurchaseAccountSupplierService::index($page, $limit);
    }

    public function create(Request $request)
    {
        try {
            $data = $request->all();
            $validator = Validator::make($data, [
                'payment_type_id'=>'required',
                'summ'=>'required',
                'purchase_id'=>'required',
            ]);
 
            if($validator->fails()){
                $error = $validator->errors()->toArray();
                return response()->json($error)->setStatusCode(417); 
            }

            return PurchaseAccountSupplierService::create($data);
        } catch (Exception $e){
            return $e->getMessage();
        }
    }

     public function card(string $id)
    {
        $data = PurchaseAccountSupplierService::card($id);
        if(!$data) return response()->json(['message'=>'Not found'], 404);
        return $data; 
    }

    public function update(Request $request, string $id)
    {
        $data = $request->all();
        $result = PurchaseAccountSupplierService::update($id, $data);
        if(!$result) return response()->json(['message'=>'Not found'], 404);
        return $result;
    }

    public function destroy(string $id)
    {
        $data = PurchaseAccountSupplierService::delete($id);
        if(!$data) return response()->json(['message'=>'Not found'], 404);
        return $data;
    }

    public function recover(string $id)
    {
        $data = PurchaseAccountSupplierService::recover($id);
        if(!$data) return response()->json(['message'=>'Not found'], 404);
        return $data;
    }
}
