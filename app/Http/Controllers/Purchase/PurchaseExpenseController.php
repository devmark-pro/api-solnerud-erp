<?php
namespace App\Http\Controllers\Purchase;

use App\Http\Controllers\Controller;
use App\Services\Purchase\PurchaseExpense\PurchaseExpenseService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PurchaseExpenseController extends Controller
{

    public function index(Request $request)
    {
        $page = $request->get('page') ?? 1;
        $limit = $request->get('limit') ?? 10;
        return PurchaseExpenseService::index($page, $limit);
    }

    public function create(Request $request)
    {
        try {
            $data = $request->all();
            $validator = Validator::make($data, [
                'address_id' => 'required', 
                'executor' => 'required',
                'summ' => 'required',
                'include_in_cost' => 'required',
                'reimbursement_expenses' => 'in:refunded,required,not_required'
            ]);
 
            if($validator->fails()){
                $error = $validator->errors()->toArray();
                return response()->json($error)->setStatusCode(417); 
            }

            return PurchaseExpenseService::create($data);
        } catch (Exception $e){
            return $e->getMessage();
        }
    }

     public function card(string $id)
    {
        $data = PurchaseExpenseService::card($id);
        if(!$data) return response()->json(['message'=>'Not found'], 404);
        return $data; 
    }

    public function update(Request $request, string $id)
    {
        $data = $request->all();
        $result = PurchaseExpenseService::update($id, $data);
        if(!$result) return response()->json(['message'=>'Not found'], 404);
        return $result;
    }

    public function destroy(string $id)
    {
        $data = PurchaseExpenseService::delete($id);
        if(!$data) return response()->json(['message'=>'Not found'], 404);
        return $data;
    }

    public function recover(string $id)
    {
        $data = PurchaseExpenseService::recover($id);
        if(!$data) return response()->json(['message'=>'Not found'], 404);
        return $data;
    }
}
