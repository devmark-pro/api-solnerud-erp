<?php

namespace App\Http\Controllers\User;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\User\User\UserService;
use Illuminate\Support\Facades\Gate;

class UserController extends Controller
{

    public function index(Request $request)
    {
        // if (!Gate::allows('user_r')) {
        //     abort(403, "Не достаточно прав");
        // }
        $requestAll = $request->all();
        return UserService::index($requestAll);
    }

    public function create(Request $request)
    {
        try {
            if (!Gate::allows('user_c')) {
                abort(403, "Не достаточно прав");
            }
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
        if (!Gate::allows('user_r')) {
                abort(403, "Не достаточно прав");
        }
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
            if (!Gate::allows('user_u')) {
                abort(403, "Не достаточно прав");
            }
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
        if (!Gate::allows('user_d')) {
                abort(403, "Не достаточно прав");
        }
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
        if (!Gate::allows('user_d')) {
                abort(403, "Не достаточно прав");
        }
        $data = UserService::recover($id);
        if(!$data) return response()->json(['message'=>'Not found'], 404);
        return $data;
    }
}
