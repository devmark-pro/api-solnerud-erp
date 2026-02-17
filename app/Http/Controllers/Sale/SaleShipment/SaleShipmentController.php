<?php

namespace App\Http\Controllers\Sale\SaleShipment;

use App\Http\Controllers\Controller;
use App\Models\Sale\SaleShipment;
use App\Services\Sale\SaleShipment\SaleShipmentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Gate;
use App\Models\Sale\SaleProduct\SaleProduct;


class SaleShipmentController extends Controller
{
    public function index(Request $request)
    {
        if (!Gate::allows('sale_r')) {
            abort(403,"Недостаточно прав");
        }
        $requestAll = $request->all();
        return SaleShipmentService::index($requestAll);
    }

    public function create(Request $request)
    {
        try {
            if (!Gate::allows('sale_u')) {
                abort(403,"Недостаточно прав");
            }
            $data = $request->all();
            $validator = Validator::make($data, [
                'shipment_date'=>'required',
                'sale_id'=>'required',
                'sale_product_id'=>'required',
            ]);
 
            if($validator->fails()){
                $error = $validator->errors()->toArray();
                return response()->json(['message'=>$error])->setStatusCode(417); 
            
            }
            
            self::shipmentValidate( 0, $data );

            return SaleShipmentService::create($data);
        } catch (Exception $e){
            return $e->getMessage();
        }
    }

    public function card(Request $request)
    {
        if (!Gate::allows('sale_r')) {
            abort(403,"Недостаточно прав");
        }
        $validator = Validator::make($request->all(), [
                'id'=>'required',
        ]);
        if($validator->fails()){
            $error = $validator->errors()->toArray();
            return response()->json(['message'=>$error])->setStatusCode(417);     
        }
        $id = $request->input('id');
        $data = SaleShipmentService::card($id);
        if(!$data) return response()->json(['message'=>'Not found'], 404);
        return $data; 
    }

    public function update(Request $request)
    {
        try {
            if (!Gate::allows('sale_u')) {
                abort(403,"Недостаточно прав");
            }

            $requestData = $request->all();
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
            
            self::shipmentValidate( $id, $data );

            $result = SaleShipmentService::update($id, $data);
            if(!$result) return response()->json(['message'=>'Not found'], 404);
            return $result;
        } catch (Exception $e){
            return $e->getMessage();
        }
    }

    public function destroy(Request $request)
    {
        if (!Gate::allows('sale_u')) {
            abort(403,"Недостаточно прав");
        }
        $validator = Validator::make($request->all(), [
            'id'=>'required',
        ]);
        if($validator->fails()){
            $error = $validator->errors()->toArray();
            return response()->json(['message'=>$error])->setStatusCode(417); 
        }
        $id = $request->input('id');
        $data = SaleShipmentService::delete($id);
        if(!$data) return response()->json(['message'=>'Not found'], 404);
        return $data;
    }

    public function recover(Request $request)
    {
        if (!Gate::allows('sale_u')) {
            abort(403,"Недостаточно прав");
        }
        $validator = Validator::make($request->all(), [
            'id'=>'required',
        ]);
        if($validator->fails()){
            $error = $validator->errors()->toArray();
            return response()->json(['message'=>$error])->setStatusCode(417); 
        }
        $id = $request->input('id');
        $data = SaleShipmentService::recover($id);
        if(!$data) return response()->json(['message'=>'Not found'], 404);
        return $data;
    }
    public function field($id, $field)
    {
        if (!Gate::allows('sale_r')) {
            abort(403,"Недостаточно прав");
        }   
        if(!(new SaleShipment())->isFillable($field)) {
            return response()->json(['message'=>"Field $field not found"], 404);}
        $data = SaleShipmentService::field($id, $field);
        if(!$data) return response()->json(['message'=>'Not found'], 404);
        return $data;
    }

    private function shipmentValidate( $id, $data ) {
        $saleProduct = SaleProduct::where([
            'sale_products.deleted_at' => null,
            'sale_shipments.deleted_at' => null,
            'sale_products.is_request_shipment' => true,
            'sale_products.sale_id' => $data['sale_id'],
            'sale_products.id' => $data['sale_product_id'],
        ])
        ->leftJoin('sale_shipments', 
            'sale_products.id', '=', 
            'sale_shipments.sale_product_id')
        ->select(
            \DB::raw("
                sale_products.id,
                sum(sale_shipments.shipped_quantity) as shipped,
                ROUND((sale_products.quantity - shipped)::numeric, 2) as need
            "))
        ->groupBy('sale_products.id')->first();

        $lastQuantity = 0;
        if($id) {
            $lastQuantity = SaleShipment::where(['id' => $id])
                ->select('last_quantity')
                ->first()->last_quantity;
        }
        if( ($saleProduct->need + $lastQuantity) < $data['shipped_quantity']) {
            throw new \Error("Пытаетесь отгрузить больше заявленного");
        } 
    }
}
