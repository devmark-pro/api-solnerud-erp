<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Services\Client\ClientService;


class ClientController extends Controller
{

    public function index()
    {
        return ClientService::index();
    }

    public function create(Request $request)
    {
        try {
            $data = $request->all();
            $validator = Validator::make($data, [
                'name'=>'required',
                'system_number' => 'unique:nomenclatures'
            ]);
 
            if($validator->fails()){
                $error = $validator->errors()->toArray();
                return response()->json($error)->setStatusCode(417); 
            }

            return ClientService::create($data);
        } catch (Exception $e){
            return $e->getMessage();
        }
    }

     public function card(string $id)
    {
        $data = ClientService::card($id);
        if(!$data) return response()->json(['error'=>'Not found'], 404);
        return $data; 
    }

    public function update(Request $request, string $id)
    {
        $data = $request->all();
        $validator = Validator::make($data, [
            'system_number' => 'unique:nomenclatures'
        ]);
 
        if($validator->fails()){
            $error = $validator->errors()->toArray();
            return response()->json($error)->setStatusCode(417); 
        }
        $result = ClientService::update($id, $data);
        if(!$result) return response()->json(['error'=>'Not found'], 404);
        return $result;
    }

    public function destroy(string $id)
    {
        $data = ClientService::delete($id);
        if(!$data) return response()->json(['error'=>'Not found'], 404);
        return $data;
    }

    public function recover(string $id)
    {
        $data = ClientService::recover($id);
        if(!$data) return response()->json(['error'=>'Not found'], 404);
        return $data;
    }
}
