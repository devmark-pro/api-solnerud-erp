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
        return ClientService::card($id);
    }

    public function update(Request $request, string $id)
    {
        return ClientService::update($id, $request->all());
    }

    public function destroy(string $id)
    {
        return ClientService::delete($id);
    }

    public function recover(string $id)
    {
        return ClientService::recover($id);
    }
}
