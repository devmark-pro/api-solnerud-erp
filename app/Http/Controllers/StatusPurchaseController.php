<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\StatusPurchase\StatusPurchaseService;

use Illuminate\Support\Facades\Validator;


class StatusPurchaseController extends Controller
{

    public function index()
    {
        return StatusPurchaseService::index();
    }

    public function create(Request $request)
    {
        try {
            $data = $request->all();
            $validator = Validator::make($data, [
                'name'=>'required',
                'color'=>'required'
            ]);
 
            if($validator->fails()){
                $error = $validator->errors()->toArray();
                return response()->json($error)->setStatusCode(417); 
            }

            return StatusPurchaseService::create($data);
        } catch (Exception $e){
            return $e->getMessage();
        }
    }

    public function card(string $id)
    {
        return StatusPurchaseService::card($id);
    }

    public function update(Request $request, string $id)
    {
        return StatusPurchaseService::update($id, $request->all());
    }

    public function destroy(string $id)
    {
        return StatusPurchaseService::delete($id);
    }

    public function recover(string $id)
    {
        return StatusPurchaseService::recover($id);
    }
}
