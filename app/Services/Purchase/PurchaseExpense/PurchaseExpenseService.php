<?php

namespace App\Services\Purchase\PurchaseExpense;
use App\Models\Purchase\PurchaseExpense\PurchaseExpense;
use App\Models\Purchase\PurchaseExpense\PurchaseExpenseDocument;
use App\Services\Purchase\PurchaseExpense\PurchaseExpenseDocument\PurchaseExpenseDocumentService;
use App\Services\Purchase\PurchaseExpense\PurchaseExpenseAddress\PurchaseExpenseAddressService;
use App\Services\Directory\Nds\NdsService;
use App\Helpers\Nds;

use Illuminate\Support\Facades\Log;


class PurchaseExpenseService
{
     public static function index($requestAll) {
        try {
            $page = 1;
            $limit = 10;
            $filter=[];
            if((array_key_exists('pagination', $requestAll)
                && (array_key_exists('page', $requestAll['pagination']))
                && (array_key_exists('limit', $requestAll['pagination']))    
            )){
                $page = $requestAll['pagination']['page'] ?? 1;
                $limit = $requestAll['pagination']['limit'] ?? 10;
            }
            
            $offset = $limit * ($page-1);
            $model = PurchaseExpense::where(['deleted_at' => null])
                // ->with('addresses')
                ;
            
            $total = $model->get()->count();

            if(array_key_exists('find', $requestAll) 
                && (is_string($requestAll['find']))
            ) {

                $find = $requestAll['find']; 
                $model->where('id', 'LIKE', "%$find%")
                    ->orWhere('name', 'ILIKE', "%$find%");
            }

            if(array_key_exists('filter', $requestAll) 
               && (is_array($requestAll['filter']))
            ) 
            {
                $filter = $requestAll['filter']; 
                $model->where($filter);
            }
            
            $count = $model->where(['deleted_at' => null])->get()->count();

            $pagesCount = ceil($count/$limit);

            $data = $model
                ->orderBy('created_at', 'desc')
                ->offset($offset)
                ->limit($limit)
                ->get();
                
            return [
                'data' => $data,
                'data_total' => [
                    'summ' => PurchaseExpense::where($filter)
                        ->where(['deleted_at' => null])
                        ->sum('summ'),
                    'summ_nds' => PurchaseExpense::where($filter)
                        ->where(['deleted_at' => null])
                        ->sum('summ_nds'),    
                ],
                'pagination' => [
                    'pagesCount' => $pagesCount,
                    'page' => $page,
                    'limit' => $limit,
                    'total' => $total,
                    'count' => $count,
                ],
            ];
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
     
    public static function create($data){
        try {
            $documents = [];
            if(array_key_exists('documents', $data)){
                $documents = $data['documents'];
                unset($data['documents']);              
            }

            if(array_key_exists('addresses', $data)){
                $addresses = $data['addresses'];
                unset($data['addresses']);   
            }
            
            $summ = $data['quantity'] * $data['rate'];
            $data['summ'] = $summ;
                        
            $ndsRate = 0;
            if(array_key_exists('nds_rate_id', $data)){
                $ndsRate = NdsService::getRateById($data['nds_rate_id']);
            }

            $ndsType = $data['nds_type'];
            $data['summ_nds'] = Nds::calculateNds($summ, $ndsType, $ndsRate);

            
            $result =  PurchaseExpense::create($data);
            if(count($documents)>0){
                $resultDocuments = PurchaseExpenseDocumentService::updateOrCreateInArray($result['id'], $result['purchase_id'], $documents);
                $result['documents'] = $resultDocuments;
            }
            if(count($addresses)>0){    
                $resultAddresses = PurchaseExpenseAddressService::updateOrCreateInArray($result['id'], $result['purchase_id'], $addresses);
                $result['addresses'] = $resultAddresses;
            }
            return $result;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
    public static function card($id){ 
        return PurchaseExpense::where(['id' => $id]);
    }
    public static function update($id, $data){ 
        try {
            if(array_key_exists('documents', $data)){
                $documents = $data['documents'];
                unset($data['documents']);              
                PurchaseExpenseDocumentService::updateOrCreateInArray($id, $data['purchase_id'], $documents);
            }

            if(array_key_exists('addresses', $data)){
                $addresses = $data['addresses'];
                unset($data['addresses']);              
                PurchaseExpenseAddressService::updateOrCreateInArray($id, $data['purchase_id'], $addresses);
            }

            $model = PurchaseExpense::where(['id' => $id])->first();

            $summ = $data['quantity'] * $data['rate'];
            $model->summ = $summ;
            $ndsRate = NdsService::getRateById($data['nds_rate_id']);
            $ndsType = $data['nds_type'];
            $model->summ_nds = Nds::calculateNds($summ, $ndsType,  $ndsRate);

            $model->update($data);
            

            // PurchaseExpense::where(['id' => $id])->first()->update($data);
            return PurchaseExpense::where(['id' => $id])->first();

        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
    public static function delete($id){ 
        try {
            return PurchaseExpense::where('id', $id)
                ->first()
                ->update(['deleted_at' => now()]);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
    public static function recover($id){ 
        try {
            return PurchaseExpense::where('id', $id)
                ->first()
                ->update(['deleted_at' => null]);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    private function updateDocuments($id, $documents){

        // purchase_expense_id:

        $doc = $documents[0];
        $doc['purchase_expense_id'] =1;
        $doc['user_id'] =57;
        $doc['purchase_id'] = $id;
    

        PurchaseExpenseDocument::create($doc);
    }
}