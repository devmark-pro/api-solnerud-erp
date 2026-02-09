<?php
namespace App\Http\Controllers\Purchase\Selection;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Services\Purchase\Purchase\Selection\PurchaseClientWarehouse\PurchaseClientWarehouseService;


class PurchaseClientWarehouseController extends Controller
{
    public function index(Request $request)
    {
        $requestAll = $request->all();
        return PurchaseClientWarehouseService::index($requestAll);
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
            $requestAll = $request->all();
            unset($requestAll['id']);
            $data = PurchaseClientWarehouseService::card($id, $requestAll);
            if(!$data) return response()->json(['message' => 'Not found'], 404);
            return $data; 

        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

}
