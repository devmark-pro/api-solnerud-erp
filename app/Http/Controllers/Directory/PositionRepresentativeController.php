<?php

namespace App\Http\Controllers\Directory;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Directory\PositionRepresentative\PositionRepresentativeService;
use Illuminate\Support\Facades\Gate;


class PositionRepresentativeController extends Controller
{
    public function index(Request $request)
    {
        // if (!Gate::allows('directory_r')) {
        //     abort(403,"Недостаточно прав");
        // }
        $page = $request->get('page') ?? 1;
        $limit = $request->get('limit') ?? 100;
        return PositionRepresentativeService::index($page, $limit);
    }

    public function create(Request $request)
    {
        try {
            if (!Gate::allows('directory_c')) {
                abort(403,"Недостаточно прав");
            }
            $updateData = $request->all();
            $validator = Validator::make($updateData, [
                'name'=>'required|unique:directory_position_representatives',
            ]);
 
            if($validator->fails()){
                $error = $validator->errors()->toArray();
               return response()->json(['message'=>$error])->setStatusCode(417); 
            
            }

            return PositionRepresentativeService::create($updateData);
        } catch (Exception $e){
            return $e->getMessage();
        }
    }

    public function card(Request $request)
    {

        try {
            if (!Gate::allows('directory_r')) {
                abort(403,"Недостаточно прав");
            }
            $validator = Validator::make($request->all(), [
                'id'=>'required',
            ]);
            if($validator->fails()){
                $error = $validator->errors()->toArray();
               return response()->json(['message'=>$error])->setStatusCode(417); 
            
            }
            $id = $request->input('id');
            $data = PositionRepresentativeService::card($id);
            if(!$data) return response()->json(['message'=>'Not found'], 404);
            return $data; 

        } catch (Exception $e){
            return $e->getMessage();
        }
    }

    public function update(Request $request)
    {
        try {
            if (!Gate::allows('directory_u')) {
                abort(403,"Недостаточно прав");
            }
            $requestData=$request->all();
            $validator = Validator::make($requestData, [
                'id'=>'required',
                'data'=>'required',
                // 'data.name'=>'required|unique:directory_position_representatives',
            ]);
            if($validator->fails()){
                $error = $validator->errors()->toArray();
                return response()->json(['message'=>$error])->setStatusCode(417); 
            
            }
            $validator = Validator::make($requestData['data'], [
                'name'=>'required|unique:directory_position_representatives,name,'.$requestData['id'],
            ]);
            if($validator->fails()){
                $error = $validator->errors()->toArray();
                return response()->json(['message'=>$error])->setStatusCode(417); 
            }
            $id = $request->input('id');
            $data = $request->input('data');
            $result = PositionRepresentativeService::update($id, $data);
            if(!$result) return response()->json(['message'=>'Not found'], 404);
            return $result;
        } catch (Exception $e){
            return $e->getMessage();
        }
    }

    public function destroy(Request $request)
    {
        try {
            if (!Gate::allows('directory_d')) {
                abort(403,"Недостаточно прав");
            }
            $validator = Validator::make($request->all(), [
                'id'=>'required',
            ]);
            if($validator->fails()){
                $error = $validator->errors()->toArray();
               return response()->json(['message'=>$error])->setStatusCode(417); 
            
            }
            $id = $request->input('id');
            $data = PositionRepresentativeService::delete($id);
            if(!$data) return response()->json(['message'=>'Not found'], 404);
            return $data;
        } catch (Exception $e){
            return $e->getMessage();
        }
    }

    public function recover(Request $request)
    {   
        try {
            if (!Gate::allows('directory_d')) {
                abort(403,"Недостаточно прав");
            }
            $validator = Validator::make($request->all(), [
                'id'=>'required',
            ]);
            if($validator->fails()){
                $error = $validator->errors()->toArray();
               return response()->json(['message'=>$error])->setStatusCode(417); 
            
            }
            $id = $request->input('id');
            $data = PositionRepresentativeService::recover($id);
            if(!$data) return response()->json(['message'=>'Not found'], 404);
            return $data;
        } catch (Exception $e){
            return $e->getMessage();
        }
    }
}