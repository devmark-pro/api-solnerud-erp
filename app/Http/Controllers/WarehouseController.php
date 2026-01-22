<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Warehouse\WarehouseService;
use Illuminate\Support\Facades\Gate;


class WarehouseController extends Controller
{
    public function index(Request $request)
    {
        // if (!Gate::allows('warehouse_r')) {
        //         abort(403, "Не достаточно прав");
        // }
        $requestAll = $request->all();
        return WarehouseService::index($requestAll);
    }

    public function create(Request $request)
    {
        try {
            if (!Gate::allows('warehouse_c')) {
                abort(403, "Не достаточно прав");
            }
            $requestData = $request->all();
            $validator = Validator::make($requestData, [
                'name'=>'required|unique:directory_warehouses',
            ]);
 
            if($validator->fails()){
                $error = $validator->errors()->toArray();
                return response()->json(['message'=>$error])->setStatusCode(417); 
            
            }

            return WarehouseService::create($requestData);
        } catch (Exception $e){
            return $e->getMessage();
        }
    }

    public function card(Request $request)
    {
        try {
            if (!Gate::allows('warehouse_r')) {
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
            $data = WarehouseService::card($id);
            if(!$data) return response()->json(['message'=>'Not found'], 404);
            return $data; 

        } catch (Exception $e){
            return $e->getMessage();
        }
    }

    public function update(Request $request)
    {
        try {
            if (!Gate::allows('warehouse_u')) {
                abort(403, "Не достаточно прав");
            }
            $requestData=$request->all();
            $validator = Validator::make($requestData, [
                'id'=>'required',
                'data'=>'required',
                // 'data.name'=>'required|unique:directory_warehouses',
            ]);
            if($validator->fails()){
                $error = $validator->errors()->toArray();
                return response()->json(['message'=>$error])->setStatusCode(417); 
            
            }
            // $validator = Validator::make($requestData['data'], [
            //     'name'=>'required|unique:directory_warehouses,name,'.$requestData['id'],
            // ]);
            if($validator->fails()){
                $error = $validator->errors()->toArray();
                return response()->json(['message'=>$error])->setStatusCode(417); 
            }
            $id = $request->input('id');
            $data = $request->input('data');
            $result = WarehouseService::update($id, $data);
            if(!$result) return response()->json(['message'=>'Not found'], 404);
            return $result;
        } catch (Exception $e){
            return $e->getMessage();
        }
    }

    public function destroy(Request $request)
    {
        try {
            if (!Gate::allows('warehouse_d')) {
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
            $data = WarehouseService::delete($id);
            if(!$data) return response()->json(['message'=>'Not found'], 404);
            return $data;
        } catch (Exception $e){
            return $e->getMessage();
        }
    }

    public function recover(Request $request)
    {   
        try {
            if (!Gate::allows('warehouse_d')) {
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
            $data = WarehouseService::recover($id);
            if(!$data) return response()->json(['message'=>'Not found'], 404);
            return $data;
        } catch (Exception $e){
            return $e->getMessage();
        }
    }
}
