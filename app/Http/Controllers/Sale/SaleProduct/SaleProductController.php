<?php

namespace App\Http\Controllers\Sale\SaleProduct;

use App\Http\Controllers\Controller;
use App\Models\Sale\SaleProduct\SaleProduct;
use App\Services\Sale\SaleProduct\SaleProductService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Gate;


class SaleProductController extends Controller
{
    public function index(Request $request)
    {
        if (!Gate::allows('sale_r')) {
            abort(403,"Не достаточно прав");
        }
        $requestAll = $request->all();
        return SaleProductService::index($requestAll);
    }

    public function create(Request $request)
    {
        try {
            if (!Gate::allows('sale_u')) {
                abort(403,"Не достаточно прав");
            }
            $data = $request->all();
            $validator = Validator::make($data, [
                'sale_id'=>'required',
                'nomenclature_id'=>'required', 
            ]);
 
            if($validator->fails())
            {
                $error = $validator->errors()->toArray();
                return response()->json(['message'=>$error])->setStatusCode(417); 
            }
            return SaleProductService::create($data);
        } catch (Exception $e){
            return $e->getMessage();
        }
    }

    public function card(Request $request)
    {
        if (!Gate::allows('sale_r')) {
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
        $data = SaleProductService::card($id);
        if(!$data) return response()->json(['message'=>'Not found'], 404);
        return $data; 
    }

    public function update(Request $request)
    {
        try {
            if (!Gate::allows('sale_u')) {
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
            if(array_key_exists('is_request_shipment', $data)) {
                $saleProduct = SaleProduct::where(['id' => $id])->first();
                if($saleProduct['shipment_type'] === 'from_factory' && (
                    !$saleProduct['purchase_id'] ||
                    !$saleProduct['purchase_address_id'])
                ) {
                    throw new \ErrorException('Не указан Адрес доставки');
                }
            }
            $result = SaleProductService::update($id, $data);
            if(!$result) return response()->json(['message'=>'Not found'], 404);
            return $result;
        } catch (Exception $e){
            return $e->getMessage();
        }
    }

    public function destroy(Request $request)
    {
        if (!Gate::allows('sale_u')) {
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
        $data = SaleProductService::delete($id);
        if(!$data) return response()->json(['message'=>'Not found'], 404);
        return $data;
    }

    public function recover(Request $request)
    {
        if (!Gate::allows('sale_u')) {
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
        $data = SaleProductService::recover($id);
        if(!$data) return response()->json(['message'=>'Not found'], 404);
        return $data;
    }
    public function field($id, $field)
    {   if (!Gate::allows('sale_r')) {
            abort(403,"Не достаточно прав");
        }
        if(!(new SaleProduct())->isFillable($field)) {
            return response()->json(['message'=>"Field $field not found"], 404);}
        $data = SaleProductService::field($id, $field);
        if(!$data) return response()->json(['message'=>'Not found'], 404);
        return $data;
    }
}
