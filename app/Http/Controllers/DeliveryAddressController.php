<?php

namespace App\Http\Controllers;

use App\Services\DeliveryAddress\DeliveryAddressService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class DeliveryAddressController extends Controller
{

    public function index(Request $request)
    {
        $page = $request->get('page') ?? 1;
        $limit = $request->get('limit') ?? 100;
        return DeliveryAddressService::index($page, $limit);
    }

    public function create(Request $request)
    {
        try {
            $data = $request->all();
            return DeliveryAddressService::create($data);
        } catch (Exception $e){
            return $e->getMessage();
        }
    }

     public function card(string $id)
    {
        $data = DeliveryAddressService::card($id);
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
            return response()->json($error)->setStatusCode(417); 
        }
        $result = DeliveryAddressService::update($id, $data);
        if(!$result) return response()->json(['message'=>'Not found'], 404);
        return $result;
    }

    public function destroy(string $id)
    {
        $data = DeliveryAddressService::delete($id);
        if(!$data) return response()->json(['message'=>'Not found'], 404);
        return $data;
    }

    public function recover(string $id)
    {
        $data = DeliveryAddressService::recover($id);
        if(!$data) return response()->json(['message'=>'Not found'], 404);
        return $data;
    }
}
