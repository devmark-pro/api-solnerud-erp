<?php

namespace App\Services\Sale\SaleExpense\SaleExpense;
use App\Models\Sale\SaleExpense\SaleExpense;
use App\Services\Sale\SaleExpense\SaleExpenseProduct\SaleExpenseProductService;
use App\Services\Sale\SaleExpense\SaleExpenseDocument\SaleExpenseDocumentService;
use App\Services\Directory\Nds\NdsService;
use App\Helpers\Nds;
use App\Models\Sale\SaleProduct\SaleProduct;
use App\Services\Sale\SaleExpense\SaleExpense\SaleExpenseHelpers;
use App\Services\Sale\SaleExpense\SaleExpense\Events\ESaleExpenseUpdateCost;


use Illuminate\Support\Facades\Log;


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
                
      
            $total = SaleExpense::where(['deleted_at' => null])
                ->where($filter)
                ->select('sale_id',
                    \DB::raw('
                        sale_id as id,
                        sum(summ) as summ, 
                        sum(quantity) as quantity,
                        sum(summ_nds) as summ_nds
                '))
                ->groupBy('sale_id')
                ->first();

            return [
                'data_total' => [
                    'summ' => $total ? round($total->summ, 2) : 0,
                    'summ_nds' => $total ? round($total->summ_nds, 2) : 0,
                    'quantity' => $total ? round($total->quantity, 2) : 0,
                ],
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

            $summ = (float)$data['quantity'] * (float)$data['rate'];
            $data['summ'] = (float)$summ;
            
            $cost = 0;
            if(array_key_exists('summ', $data) &&
                array_key_exists('quantity', $data) &&
                array_key_exists('sale_product_ids', $data) &&
                array_key_exists('include_in_cost', $data)
            ) {

                $summ = $data['summ'];
                $quantity = $data['quantity'];
                $saleProductIds = $data['sale_product_ids'];
                $includeInCost = $data['include_in_cost'];
                
                $cost = SaleExpenseHelpers::calculateCost(
                    $summ, 
                    $quantity, 
                    $saleProductIds, 
                    $includeInCost,
                    $formula
                );
                $data['cost_formula'] = $formula;
                $data['cost'] = $cost;
            }

            $documents = [];
            $products = [];
            
            if(array_key_exists('documents', $data)){
                $documents = $data['documents'];
                unset($data['documents']);              
            }

            if(array_key_exists('sale_product_ids', $data)){
                $products = $data['sale_product_ids'];
                $saleProductIds = $data['sale_product_ids'];
                unset($data['sale_product_ids']);   
            }
            
            
            $ndsRate = null;
            if(array_key_exists('nds_rate_id', $data) && $data['nds_rate_id']){
                $ndsRate = NdsService::getRateById($data['nds_rate_id']);
            }

            $isNdsInPrice = $data['is_nds_in_price'];

            $data['summ_nds'] = Nds::calculateNds($summ, $isNdsInPrice, $ndsRate);
            $data['nds_rate'] = $ndsRate;
         
                
            $model =  SaleExpense::create($data);
            if(count($documents)>0){
                $resultDocuments = SaleExpenseDocumentService::updateOrCreateInArray($model['id'], $model['sale_id'], $documents);
                $model['documents'] = $resultDocuments;
            }
            if(count($products)>0){    
                $resultProducts = SaleExpenseProductService::deleteAndCreateArray($model['id'], $model['sale_id'], $products);
                $model['products'] = $resultProducts;
            }


            ESaleExpenseUpdateCost::dispatch(
                [
                    'cost' => $cost,
                    'sale_product_ids'=> $products
                ]
            );

            return $model;

        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
    public static function card($id) { 
        return SaleExpense::where(['id' => $id])->first();    
    }
    public static function update($id, $data){ 
        try {
             if(array_key_exists('documents', $data)){
                $documents = $data['documents'];
                unset($data['documents']);              
                SaleExpenseDocumentService::updateOrCreateInArray($id, $data['sale_id'], $documents);
            }
            if(array_key_exists('sale_product_ids', $data)) {
                $products = $data['sale_product_ids'];
                unset($data['sale_product_ids']);
                SaleExpenseProductService::deleteAndCreateArray(
                    $id, $data['sale_id'], $products
                );         
            }
            
            $model = SaleExpense::where(['id' => $id])->first();

            $summ = $data['quantity'] * $data['rate'];
            $model->summ = $summ;
            $ndsRate = null;
            if(array_key_exists('nds_rate_id', $data) && $data['nds_rate_id']){
                $ndsRate = NdsService::getRateById($data['nds_rate_id']);
            }
            $data['nds_rate'] = $ndsRate;
            $isNdsInPrice = $data['is_nds_in_price'];
            $model->summ_nds = Nds::calculateNds($summ, $isNdsInPrice,  $ndsRate);
            
            $summ = $model->summ;
            $quantity = $model->quantity;
            $saleProductIds = $model->sale_product_ids;
            $includeInCost = $model->include_in_cost;
            
            if(array_key_exists('summ', $data)) {
                $summ = $data['summ'];
            }
            if(array_key_exists('quantity', $data)) {
                $quantity = $data['quantity'];
            }
            if(array_key_exists('sale_product_ids', $data)) {
                $saleProductIds = $data['sale_product_ids'];
            }
            if(array_key_exists('include_in_cost', $data)) {
                $includeInCost = $data['include_in_cost'];
            }
          
            $cost = SaleExpenseHelpers::calculateCost(
                $summ, 
                $quantity, 
                $saleProductIds, 
                $includeInCost,
                $formula,
            );
            
            $data['cost'] = $cost;
            $data['cost_formula'] = $formula;

            $model->update($data);

            return SaleExpense::where(['id' => $id])->first();    
            
            // return $model->get();

        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
    public static function delete($id){ 
        try {
            return SaleExpense::where('id', $id)->first()->update(['deleted_at' => now()]);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
    public static function recover($id){ 
        try {
            return SaleExpense::where('id', $id)->fitst()->update(['deleted_at' => null]);
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

    private static function calculateCost($summ = 0, $quantity=0, $saleProductIds=[], $includeInCost=false){ 
        try {

            if(!$includeInCost) {
                return 0;
            }

            $saleProducts = SaleProduct::select('id', 'shipped')
                ->whereIn('id', $saleProductIds)->get()->toArray();

            $summPr = 0;

            foreach($saleProducts as $pr){
                if(array_key_exists('shipped',$pr)){
                    $summPr += $pr['shipped'];
                }
            }

            if(!$summPr || !$quantity) {
                $cost = 0;
            } else {
                $cost = round(($summ * $quantity / $summPr) / $quantity, 2);
            }
            return (float)$cost;

        } catch (Exception $e) {
            return $e->getMessage();
        }   

    }

}