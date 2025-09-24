<?php

namespace App\Http\Controllers\User;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\User\User\UserService;


class UserController extends Controller
{

    public function index(Request $request)
    {
        $requestAll = $request->all();
        return UserService::index($requestAll);
    }

    public function create(Request $request)
    {
        try {
            $data = $request->all();
            $validator = Validator::make($data, [
                'name'=>'required',
                'surname'=>'required',
                'employee_position_id'=>'required',
                'employee_status_id'=>'required',
            ]);
 
            if($validator->fails()){
                $error = $validator->errors()->toArray();
               return response()->json(['message'=>$error])->setStatusCode(417); 
            
            }

            return UserService::create($data);
        } catch (Exception $e){
            return $e->getMessage();
        }
    }

     public function card(Request $request)
    {
         $validator = Validator::make($request->all(), [
                'id'=>'required',
        ]);
        if($validator->fails()){
            $error = $validator->errors()->toArray();
            return response()->json(['message'=>$error])->setStatusCode(417);     
        }
        $id = $request->input('id');
        $data = UserService::card($id);
        if(!$data) return response()->json(['message'=>'Not found'], 404);
        return $data; 
    }

    public function update(Request $request)
    {
        try {
            $requestData=$request->all();
            $validator = Validator::make($requestData, [
                'id'=>'required',
                'data'=>'required',
            ]);
            if($validator->fails()){
                $error = $validator->errors()->toArray();
                return response()->json(['message'=>$error])->setStatusCode(417); 
            
            }
            if($validator->fails()){
                $error = $validator->errors()->toArray();
                return response()->json(['message'=>$error])->setStatusCode(417); 
            }
            $id = $request->input('id');
            $data = $request->input('data');
            $result = UserService::update($id, $data);
            if(!$result) return response()->json(['message'=>'Not found'], 404);
            return $result;
        } catch (Exception $e){
            return $e->getMessage();
        }
    }

    public function destroy(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id'=>'required',
        ]);
        if($validator->fails()){
            $error = $validator->errors()->toArray();
            return response()->json(['message'=>$error])->setStatusCode(417); 
        }
        $id = $request->input('id');
        $data = UserService::delete($id);
        if(!$data) return response()->json(['message'=>'Not found'], 404);
        return $data;
    }

    public function recover(string $id)
    {
        $data = UserService::recover($id);
        if(!$data) return response()->json(['message'=>'Not found'], 404);
        return $data;
    }
}
