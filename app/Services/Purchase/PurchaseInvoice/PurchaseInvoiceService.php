<?php

namespace App\Services\Purchase\PurchaseInvoice;
use App\Models\Purchase\PurchaseInvoice;
use App\Services\Directory\Nds\NdsService;
use App\Helpers\Nds; 

class PurchaseInvoiceService
{
     public static function index($requestAll) {
        try {
            $page = 1;
            $limit = 10;
            if((array_key_exists('pagination', $requestAll)
                && (array_key_exists('page', $requestAll['pagination']))
                && (array_key_exists('limit', $requestAll['pagination']))    
            )){
                $page = $requestAll['pagination']['page'] ?? 1;
                $limit = $requestAll['pagination']['limit'] ?? 10;
            }
            
            $offset = $limit * ($page-1);
            $model = PurchaseInvoice::where(['deleted_at' => null])
                ->with(['user']);
            
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
                ->orderBy('created_at', 'asc')
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
            $ndsRate = NdsService::getRateById($data['nds_rate_id']);
            $data['summ_nds'] = Nds::calculateNds($data['summ'], $data['nds_type'],  $ndsRate);
            $data['nds_rate'] = $ndsRate;
            return PurchaseInvoice::create($data);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
    public static function card($id){ 
        return PurchaseInvoice::where(['id' => $id])
            ->with(['user'])
            ->first();    
    }
    public static function update($id, $data){ 
        try {   
            $ndsRate = NdsService::getRateById($data['nds_rate_id']);
            $data['summ_nds'] = Nds::calculateNds($data['summ'], $data['nds_type'],  $ndsRate);
            $data['nds_rate'] = $ndsRate;
            PurchaseInvoice::where('id', $id)
                ->first()
                ->update($data);
            return PurchaseInvoice::where('id', $id)
                ->with(['user'])
                ->first();

        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
    public static function delete($id){ 
        try {
            return PurchaseInvoice::where('id', $id)->update(['deleted_at' => now()]);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
    public static function recover($id){ 
        try {
            return PurchaseInvoice::where('id', $id)->update(['deleted_at' => null]);
        } catch (Exception $e) {
            return $e->getMessage();
        }
     }
}