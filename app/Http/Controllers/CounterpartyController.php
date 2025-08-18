<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
// use App\Http\Controllers\Controller;
use App\Services\Counterparty\CounterpartyService;


class CounterpartyController extends Controller
{

    public function index()
    {
        return CounterpartyService::index();
    }

    public function create(Request $request)
    {
        try {
            $data = $request->all();
            $validator = Validator::make($data, [
                'name'=>'required',
            ]);
 
            if($validator->fails()){
                $error = $validator->errors()->toArray();
                return response()->json($error)->setStatusCode(417); 
            }

            return CounterpartyService::create($data);
        } catch (Exception $e){
            return $e->getMessage();
        }
    }

    public function card(string $id)
    {
        return CounterpartyService::card($id);
    }

    public function update(Request $request, string $id)
    {
        return CounterpartyService::update($id, $request->all());
    }

    public function destroy(string $id)
    {
        return CounterpartyService::delete($id);
    }

    public function recover(string $id)
    {
        return CounterpartyService::recover($id);
    }
}
