<?php

namespace App\Http\Controllers\WarehouseRemains;

use App\Http\Controllers\Controller;
use App\Services\WarehouseRemains\WarehouseRemainsPackingType\WarehouseRemainsPackingTypeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Gate;




class WarehouseRemainsPackingTypeController extends Controller
{
    public function index(Request $request)
    {
        $requestAll = $request->all();
        return WarehouseRemainsPackingTypeService::index($requestAll);
    }
    public function card(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'id'=>'required',
            ]);
            if($validator->fails()) {
                $error = $validator->errors()->toArray();
                return response()->json(['message'=>$error])->setStatusCode(417); 
            
            }
            $id = $request->input('id');
            $data = WarehouseRemainsPackingTypeService::card($id);
            if(!$data) return response()->json(['message' => 'Not found'], 404);
            return $data; 

        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}
