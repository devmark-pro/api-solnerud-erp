<?php

namespace App\Services\Sale\SaleExpense\SaleExpense;
use App\Models\Sale\SaleExpense\SaleExpense;
use App\Services\Sale\SaleExpense\SaleExpenseProduct\SaleExpenseProductService;
use App\Services\Sale\SaleExpense\SaleExpenseDocument\SaleExpenseDocumentService;



class SaleExpenseService
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
            $model = SaleExpense::where(['deleted_at' => null]);
               // ->with([])
            
            $total = $model->get()->count();

            if(array_key_exists('find', $requestAll) 
                && (is_string($requestAll['find']))
            ) {

                $find = $requestAll['find']; 
                $model->where('id', 'LIKE', "%$find%")
                    ->orWhere('name', 'LIKE', "%$find%");
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

            if(array_key_exists('products', $data)){
                $products = $data['products'];
                unset($data['products']);   
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
         
            $result =  SaleExpense::create($data);
            if(count($documents)>0){
                $resultDocuments = SaleExpenseDocumentService::updateOrCreateInArray($result['id'], $result['sale_id'], $documents);
                $result['documents'] = $resultDocuments;
            }
            if(count($products)>0){    
                $resultAddresses = SaleExpenseProductService::updateOrCreateInArray($result['id'], $result['sale_id'], $addresses);
                $result['products'] = $resultProducts;
            }
            return $result;

        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
    public static function card($id){ 
        return SaleExpense::where(['id' => $id])
            //->with([])
            ->first();    
    }
    public static function update($id, $data){ 
        try {
            SaleExpense::where('id', $id)->first()->update($data);
            return SaleExpense::where('id', $id)
                //->with([])
                ->first();

        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
    public static function delete($id){ 
        try {
            return SaleExpense::where('id', $id)->update(['deleted_at' => now()]);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
    public static function recover($id){ 
        try {
            return SaleExpense::where('id', $id)->update(['deleted_at' => null]);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
    public static function field($id, $field){ 
        try {
            $result = SaleExpense::where('id', $id)->select($field)->first();
            if(!$result ) return;
            return $result[$field];
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}