<?php

namespace App\Services\Expense\Expense;
use App\Models\Expense\Expense;
use App\Services\Expense\ExpenseDocument\ExpenseDocumentService;
use App\Services\Directory\Nds\NdsService;
use App\Helpers\Nds;

class ExpenseService
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
            $model = Expense::where(['deleted_at' => null]);
            $total = $model->get()->count();

            $model = self::find($model, $requestAll);
            $model = self::filter($model, $requestAll);

            $modelTotal = clone $model;

            $count = $model->where(['deleted_at' => null])->get()->count();

            $pagesCount = ceil($count/$limit);

            $data = $model
                ->orderBy('created_at', 'desc')
                ->offset($offset)
                ->limit($limit)
                ->get();

            $total = $modelTotal
                ->select('type_flow_id',
                    \DB::raw('
                        type_flow_id,
                        sum(summ) as summ
                    '))
                ->groupBy('type_flow_id')
                ->get();

            
            return [
                'data_total' => $total,
                'data' => $data,
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
            $summ = $data['quantity'] * $data['rate'];
            $data['summ'] = $summ;
                        
            $ndsRate = null;
            if(array_key_exists('nds_rate_id', $data) && $data['nds_rate_id']){
                $ndsRate = NdsService::getRateById($data['nds_rate_id']);
            }


            $isNdsInPrice = $data['is_nds_in_price'];

            $data['summ_nds'] = Nds::calculateNds($summ, $isNdsInPrice, $ndsRate);
            $data['nds_rate'] = $ndsRate;
         
            $result =  Expense::create($data);
            if(count($documents)>0){
                $resultDocuments = ExpenseDocumentService::updateOrCreateInArray($result['id'], $documents);
                $result['documents'] = $resultDocuments;
            }
            return $result;

        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
    public static function card($id){ 
        return Expense::where(['id' => $id])
            ->first();    
    }
    public static function update($id, $data){ 
        try {
            if(array_key_exists('documents', $data)){
                $documents = $data['documents'];
                unset($data['documents']);              
                ExpenseDocumentService::updateOrCreateInArray($id, $documents);
            }

            $model = Expense::where(['id' => $id])->first();

            $summ = $data['quantity'] * $data['rate'];
            $model->summ = $summ;
            $ndsRate = null;
            if(array_key_exists('nds_rate_id', $data) && $data['nds_rate_id']){
                $ndsRate = NdsService::getRateById($data['nds_rate_id']);
            }
            // $ndsType = $data['nds_type'];
            $data['nds_rate'] = $ndsRate;
            $isNdsInPrice = $data['is_nds_in_price'];
            $model->summ_nds = Nds::calculateNds($summ, $isNdsInPrice,  $ndsRate);

            $model->update($data);
            

            // PurchaseExpense::where(['id' => $id])->first()->update($data);
            return Expense::where(['id' => $id])->first();

            // Expense::where('id', $id)->first()->update($data);
            // return Expense::where('id', $id)
            //     //->with([])
            //     ->first();

        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
    public static function delete($id){ 
        try {
            return Expense::where('id', $id)->update(['deleted_at' => now()]);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
    public static function recover($id){ 
        try {
            return Expense::where('id', $id)->update(['deleted_at' => null]);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
    public static function field($id, $field){ 
        try {
            $result = Expense::where('id', $id)->select($field)->first();
            if(!$result ) return;
            return $result[$field];
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    private static function find($model, $requestAll){
        if(array_key_exists('find', $requestAll) 
            && (is_string($requestAll['find']))
        ) {
            $find = $requestAll['find']; 
            $model->where('id', 'LIKE', "%$find%")
                 ->orWhere('name', 'ILIKE', "%$find%");       
        }
        return $model;
    }

    
    private static function filter($model, $requestAll){
        if(array_key_exists('filter', $requestAll) 
            && (is_array($requestAll['filter']))
        ) 
        {
            $filter = $requestAll['filter'];
            if(array_key_exists('service_date_from', $filter)) {
                $model->whereDate('service_date_from', '>=', $filter['service_date_from']);
                unset($filter['service_date_from']);
            }

            if(array_key_exists('service_date_to', $filter)) {
                $model->whereDate('service_date_to', '<=', $filter['service_date_to']);
                unset($filter['service_date_to']);
            }

            foreach($filter as $key => $item){
                if(is_array($item) && count($item)) {
                    $model->whereIn($key, $item);
                }
                unset($filter[$key]);
            }
            $model->where($filter);
        }
        return $model;
    }
}