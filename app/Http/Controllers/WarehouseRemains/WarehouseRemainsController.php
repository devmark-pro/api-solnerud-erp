<?php

namespace App\Http\Controllers\WarehouseRemains;

use App\Http\Controllers\Controller;
use App\Models\WarehouseRemains\WarehouseRemains\WarehouseRemains;
use App\Services\WarehouseRemains\WarehouseRemains\WarehouseRemainsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Gate;


class WarehouseRemainsController extends Controller
{
    public function index(Request $request)
    {
        if (!Gate::allows('warehouse_remains_r')) {
            abort(403, "Недостаточно прав");
        }
        $requestAll = $request->all();
        return WarehouseRemainsService::index($requestAll);
    }

    public function create(Request $request)
    {
        try {
            if (!Gate::allows('warehouse_remains_c')) {
                abort(403, "Недостаточно прав");
            }
            $data = $request->all();
            $validator = Validator::make($data, [
                'nomenclature_id'=>'required',
                'purchase_id'=>'required',
                'warehouse_id'=>'required',
            ]);
 
            if($validator->fails()){
                $error = $validator->errors()->toArray();
                return response()->json(['message'=>$error])->setStatusCode(417); 
            
            }
            return WarehouseRemainsService::create($data);
        } catch (Exception $e){
            return $e->getMessage();
        }
    }

    public function card(Request $request)
    {
        try {
            if (!Gate::allows('warehouse_remains_r')) {
                abort(403, "Недостаточно прав");
            }
            $validator = Validator::make($request->all(), [
                    'id'=>'required',
            ]);
            if($validator->fails()){
                $error = $validator->errors()->toArray();
                return response()->json(['message'=>$error])->setStatusCode(417);     
            }
            $id = $request->input('id');
            $type = $request->input('type');
        
            $data = WarehouseRemainsService::card($id, $type);
            if(!$data) return response()->json(['message'=>'Not found'], 404);
            return $data; 
        } catch (Exception $e){
            return $e->getMessage();
        }
    }

    public function update(Request $request)
    {
        try {
            if (!Gate::allows('warehouse_remains_u')) {
                abort(403, "Недостаточно прав");
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
            $result = WarehouseRemainsService::update($id, $data);
            if(!$result) return response()->json(['message'=>'Not found'], 404);
            return $result;
        } catch (Exception $e){
            return $e->getMessage();
        }
    }

    public function destroy(Request $request)
    {
        if (!Gate::allows('warehouse_remains_d')) {
            abort(403, "Недостаточно прав");
        }
        $validator = Validator::make($request->all(), [
            'id'=>'required',
        ]);
        if($validator->fails()){
            $error = $validator->errors()->toArray();
            return response()->json(['message'=>$error])->setStatusCode(417); 
        }
        $id = $request->input('id');
        $data = WarehouseRemainsService::delete($id);
        if(!$data) return response()->json(['message'=>'Not found'], 404);
        return $data;
    }

    public function recover(Request $request)
    {
        if (!Gate::allows('warehouse_remains_d')) {
            abort(403, "Недостаточно прав");
        }
        $validator = Validator::make($request->all(), [
            'id'=>'required',
        ]);
        if($validator->fails()){
            $error = $validator->errors()->toArray();
            return response()->json(['message'=>$error])->setStatusCode(417); 
        }
        $id = $request->input('id');
        $data = WarehouseRemainsService::recover($id);
        if(!$data) return response()->json(['message'=>'Not found'], 404);
        return $data;
    }
    public function field($id, $field)
    {   
        if(!(new WarehouseRemains())->isFillable($field)) {
            return response()->json(['message'=>"Field $field not found"], 404);}
        $data = WarehouseRemainsService::field($id, $field);
        if(!$data) return response()->json(['message'=>'Not found'], 404);
        return $data;
    }
}
