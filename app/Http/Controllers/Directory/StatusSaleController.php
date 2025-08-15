<?php

namespace App\Http\Controllers\Directory;

use Illuminate\Http\Request;
use App\Services\Directory\StatusSale\StatusSaleService;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;


class StatusSaleController extends Controller
{

    public function index()
    {
        return StatusSaleService::index();
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

            return StatusSaleService::create($data);
        } catch (Exception $e){
            return $e->getMessage();
        }
    }

    public function card(string $id)
    {
        return StatusSaleService::card($id);
    }

    public function update(Request $request, string $id)
    {
        return StatusSaleService::update($id, $request->all());
    }

    public function destroy(string $id)
    {
        return StatusSaleService::delete($id);
    }

    public function recover(string $id)
    {
        return StatusSaleService::recover($id);
    }
}
