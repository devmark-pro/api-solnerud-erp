<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Services\Purchase\PurchaseService;


class PurchaseController extends Controller
{

    public function index()
    {
        return PurchaseService::index();
    }

    public function create(Request $request)
    {
        try {
            $data = $request->all();
            // $validator = Validator::make($data, [
            //     'name'=>'required',
            // ]);
 
            // if($validator->fails()){
            //     $error = $validator->errors()->toArray();
            //     return response()->json($error)->setStatusCode(417); 
            // }

            return PurchaseService::create($data);
        } catch (Exception $e){
            return $e->getMessage();
        }
    }

    public function card(string $id)
    {
        return PurchaseService::card($id);
    }

    public function update(Request $request, string $id)
    {
        return PurchaseService::update($id, $request->all());
    }

    public function destroy(string $id)
    {
        return PurchaseService::delete($id);
    }

    public function recover(string $id)
    {
        return PurchaseService::recover($id);
    }
}
