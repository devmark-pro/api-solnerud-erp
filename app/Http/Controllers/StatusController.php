<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Validator;
use App\Services\Status\StatusService;

use Illuminate\Support\Facades\Validator;


class StatusController extends Controller
{

    public function index()
    {
        return StatusService::index();
    }

    public function create(Request $request)
    {
        try {
            $data = $request->all();
            // $validate = Validator::make($data,[
            //     'code'=>'required',
            //     'name'=>'required'
            // ]);

            $validator = Validator::make($data, [
                'code'=>'required',
                'name'=>'required'
            ]);
 
            if($validator->fails()){
                $error = $validator->errors()->toArray();
                return response()->json($error)->setStatusCode(417); 
            }

            return StatusService::create($data);
        } catch (Exception $e){
            return $e->getMessage();
        }
    }

    public function card(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        //
    }
}
