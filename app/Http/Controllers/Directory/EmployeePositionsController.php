<?php

namespace App\Http\Controllers\Directory;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Directory\EmployeePositions\EmployeePositionsService;


class EmployeePositionsController extends Controller
{
    public function index()
    {
        return EmployeePositionsService::index();
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

            return EmployeePositionsService::create($data);
        } catch (Exception $e){
            return $e->getMessage();
        }
    }

     public function card(string $id)
    {
        $data = EmployeePositionsService::card($id);
        if(!$data) return response()->json(['error'=>'Not found'], 404);
        return $data; 
    }

    public function update(Request $request, string $id)
    {
        $data = EmployeePositionsService::update($id, $request->all());
        if(!$data) return response()->json(['error'=>'Not found'], 404);
        return $data;
    }

    public function destroy(string $id)
    {
        $data = EmployeePositionsService::delete($id);
        if(!$data) return response()->json(['error'=>'Not found'], 404);
        return $data;
    }

    public function recover(string $id)
    {
        $data = EmployeePositionsService::recover($id);
        if(!$data) return response()->json(['error'=>'Not found'], 404);
        return $data;
    }
}
