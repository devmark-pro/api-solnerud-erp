<?php

namespace App\Http\Controllers\Purchase;

use App\Services\Purchase\PurchaseInvoice\PurchaseInvoiceService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;


class PurchaseInvoiceController extends Controller
{

    public function index(Request $request)
    {
        $page = $request->get('page') ?? 1;
        $limit = $request->get('limit') ?? 10;
        return PurchaseInvoiceService::index($page, $limit);
    }

    public function create(Request $request)
    {
        try {
            $data = $request->all();
            $validator = Validator::make($data, [
                'number'=>'required|unique:purchase_invoices',
                'date'=>'required',
                'summ'=>'required',
                'purchase_id' => 'required',
            ]);
 
            if($validator->fails()){
                $error = $validator->errors()->toArray();
                return response()->json($error)->setStatusCode(417); 
            }

            return PurchaseInvoiceService::create($data);
        } catch (Exception $e){
            return $e->getMessage();
        }
    }

     public function card(string $id)
    {
        $data = PurchaseInvoiceService::card($id);
        if(!$data) return response()->json(['message'=>'Not found'], 404);
        return $data; 
    }

    public function update(Request $request, string $id)
    {
        $data = $request->all();
        $result = PurchaseInvoiceService::update($id, $data);
        if(!$result) return response()->json(['message'=>'Not found'], 404);
        return $result;
    }

    public function destroy(string $id)
    {
        $data = PurchaseInvoiceService::delete($id);
        if(!$data) return response()->json(['message'=>'Not found'], 404);
        return $data;
    }

    public function recover(string $id)
    {
        $data = PurchaseInvoiceService::recover($id);
        if(!$data) return response()->json(['message'=>'Not found'], 404);
        return $data;
    }
}
