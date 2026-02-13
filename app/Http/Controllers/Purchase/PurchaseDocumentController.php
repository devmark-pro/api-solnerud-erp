<?php
namespace App\Http\Controllers\Purchase;

use App\Http\Controllers\Controller;
use App\Services\Purchase\PurchaseDocument\PurchaseDocumentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Gate;

class PurchaseDocumentController extends Controller
{

    public function index(Request $request)
    {
        // if (!Gate::allows('purchase_r')) {
        //     abort(403,"Недостаточно прав");
        // }
        $page = $request->get('page') ?? 1;
        $limit = $request->get('limit') ?? 10;
        return PurchaseDocumentService::index($page, $limit);
    }

    public function create(Request $request)
    {
        try {
            if (!Gate::allows('purchase_u')) {
                abort(403,"Недостаточно прав");
            }
            $data = $request->all();
            $validator = Validator::make($data, [
                'name'=>'required',
            ]);
 
            if($validator->fails()){
                $error = $validator->errors()->toArray();
                return response()->json(['message'=>$error])->setStatusCode(417); 
            
            }

            return PurchaseDocumentService::create($data);
        } catch (Exception $e){
            return $e->getMessage();
        }
    }

    public function card(string $id)
    {
        if (!Gate::allows('purchase_r')) {
            abort(403,"Недостаточно прав");
        }
        $data = PurchaseDocumentService::card($id);
        if(!$data) return response()->json(['message'=>'Not found'], 404);
        return $data; 
    }

    public function update(Request $request, string $id)
    {
        if (!Gate::allows('purchase_u')) {
            abort(403,"Недостаточно прав");
        }
        $data = $request->all();
        $result = PurchaseDocumentService::update($id, $data);
        if(!$result) return response()->json(['message'=>'Not found'], 404);
        return $result;
    }

    public function destroy(string $id)
    {
        if (!Gate::allows('purchase_u')) {
            abort(403,"Недостаточно прав");
        }
        $data = PurchaseDocumentService::delete($id);
        if(!$data) return response()->json(['message'=>'Not found'], 404);
        return $data;
    }

    public function recover(string $id)
    {
        if (!Gate::allows('purchase_u')) {
            abort(403,"Недостаточно прав");
        }
        $data = PurchaseDocumentService::recover($id);
        if(!$data) return response()->json(['message'=>'Not found'], 404);
        return $data;
    }
}
