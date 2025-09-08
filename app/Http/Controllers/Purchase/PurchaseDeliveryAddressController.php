<?php

namespace App\Http\Controllers\Purchase;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Services\Purchase\PurchaseDeliveryAddress\PurchaseDeliveryAddressService;

class PurchaseDeliveryAddressController extends Controller
{
    public function index(Request $request)
    {
        $page = $request->get('page') ?? 1;
        $limit = $request->get('limit') ?? 100;
        return PurchaseDeliveryAddressService::index($page, $limit);
    }

    public function create(Request $request)
    {
        try {
            $data = $request->all();
            return PurchaseDeliveryAddressService::create($data);
        } catch (Exception $e){
            return $e->getMessage();
        }
    }

     public function card(string $id)
    {
        $data = PurchaseDeliveryAddressService::card($id);
        if(!$data) return response()->json(['message'=>'Not found'], 404);
        return $data; 
    }

    public function update(Request $request, string $id)
    {
        $data = $request->all();
        $validator = Validator::make($data, [
            'system_number' => 'unique:nomenclatures'
        ]);
 
        if($validator->fails()){
            $error = $validator->errors()->toArray();
           return response()->json(['message'=>$error])->setStatusCode(417); 
            
        }
        $result = PurchaseDeliveryAddressService::update($id, $data);
        if(!$result) return response()->json(['message'=>'Not found'], 404);
        return $result;
    }

    public function destroy(string $id)
    {
        $data = PurchaseDeliveryAddressService::delete($id);
        if(!$data) return response()->json(['message'=>'Not found'], 404);
        return $data;
    }

    public function recover(string $id)
    {
        $data = PurchaseDeliveryAddressService::recover($id);
        if(!$data) return response()->json(['message'=>'Not found'], 404);
        return $data;
    }
}
