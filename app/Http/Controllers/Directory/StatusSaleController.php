<?php

namespace App\Http\Controllers\Directory;

use Illuminate\Http\Request;
use App\Services\Directory\StatusSale\StatusSaleService;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;


class StatusSaleController extends Controller
{

    public function index(Request $request)
    {
        $page = $request->get('page') ?? 1;
        $limit = $request->get('limit') ?? 100;
        return StatusSaleService::index($page, $limit);
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
        $data = StatusSaleService::card($id);
        if(!$data) return response()->json(['message'=>'Not found'], 404);
        return $data; 
    }

    public function update(Request $request, string $id)
    {
        $data = StatusSaleService::update($id, $request->all());
        if(!$data) return response()->json(['message'=>'Not found'], 404);
        return $data;
    }

    public function destroy(string $id)
    {
        $data = StatusSaleService::delete($id);
        if(!$data) return response()->json(['message'=>'Not found'], 404);
        return $data;
    }

    public function recover(string $id)
    {
        $data = StatusSaleService::recover($id);
        if(!$data) return response()->json(['message'=>'Not found'], 404);
        return $data;
    }
}
