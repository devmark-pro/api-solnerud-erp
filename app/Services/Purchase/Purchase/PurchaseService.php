<?php
namespace App\Services\Purchase\Purchase;
use App\Models\Purchase\Purchase;
use App\Helpers\Nds; 
use App\Services\Directory\Nds\NdsService;

class PurchaseService
{
    public static function index($requestAll) {
        try {
            $page = 1;
            $limit = 100;
            if((array_key_exists('pagination', $requestAll)
                && (array_key_exists('page', $requestAll['pagination']))
                && (array_key_exists('limit', $requestAll['pagination']))    
            )){
                $page = $requestAll['pagination']['page'] ?? 1;
                $limit = $requestAll['pagination']['limit'] ?? 10;
            }
            
            $offset = $limit * ($page-1);
            $model = Purchase::where(['deleted_at' => null])
                 ->with([
                'statusPurchase', 
                // 'purchaseType', 
                'counterparty', 
                'nomenclature', 
                'client',
                'packingType',
                'deliveryMethod',
                'deliveryAddress',
                'invoice',
                'accountSupplier',
                'receipts',
                // 'expenses',
                // 'document'
            ]);
            
            $total = $model->get()->count();

            $model = self::find($model, $requestAll);
            $model = self::filter($model, $requestAll);
            
            $count = $model->where(['deleted_at' => null])->get()->count();

            $pagesCount = ceil($count/$limit);

            $data = $model
                ->orderBy('created_at', 'desc')
                ->offset($offset)
                ->limit($limit)
                ->get();

            $dataTotal = Purchase::select('delivery_method_id',
                    \DB::raw('
                        count(*) as count
                    '))
                ->where(['deleted_at' => null])
                ->with(['deliveryMethod'])
                ->groupBy('delivery_method_id')
                ->get();

            
            return [
                'data_total' => $dataTotal,
                'pagination' => [
                    'pagesCount' => $pagesCount,
                    'page' => $page,
                    'limit' => $limit,
                    'total' => $total,
                    'count' => $count,
                ],
                'data' => $data,
            ];
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public static function create($data){
        try {
            return Purchase::create($data);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
    public static function card($id){ 

        return Purchase::where(['id' => $id])
            ->with([
                'statusPurchase', 
                // 'purchaseType', 
                'counterparty', 
                'nomenclature', 
                'client',
                'packingType',
                'deliveryMethod',
                'deliveryAddress',
                'invoice',
                'accountSupplier',
                'receipts',
                // 'expenses',
                // 'document'
            ])->first();
    }
   public static function update($id, $data){ 
        try {

            $model = Purchase::where('id', $id)->first();
                
            $price = $data['price'];
            $count = $model->count;
            
            $summ = $price * $count;
            $data['summ'] = $summ;
            $ndsRate = null;
            if(array_key_exists('nds_rate_id', $data) && $data['nds_rate_id']){
                $ndsRate = NdsService::getRateById($data['nds_rate_id']);
            }
            // $ndsType = $data['nds_type'];
            $isNdsInPrice = $data['is_nds_in_price'];

            $data['summ_nds'] = Nds::calculateNds($summ, $isNdsInPrice, $ndsRate);
            $data['nds_rate'] = $ndsRate;
            $model->update($data);

            return Purchase::where('id', $id)
                ->with([
                    'statusPurchase', 
                    // 'purchaseType', 
                    'counterparty', 
                    'nomenclature', 
                    'client',
                    'packingType',
                    'deliveryMethod',
                    'deliveryAddress',
                    'invoice',
                    'accountSupplier',
                    'receipts',
                    // 'expenses',
                    // 'document'
                ])
                ->first();

        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
    public static function delete($id){ 
        try {
            return Purchase::where('id', $id)->first()->update(['deleted_at' => now()]);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
    public static function recover($id){ 
        try {
            return Purchase::where('id', $id)->fitst()->update(['deleted_at' => null]);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
     private static function find($model, $requestAll){
        if(array_key_exists('find', $requestAll) 
            && (is_string($requestAll['find']))
        ) {
            $find = $requestAll['find']; 
            $model->where('id', 'LIKE', "%$find%");       
        }
        return $model;
    }
    private static function filter($model, $requestAll){
        if(array_key_exists('filter', $requestAll) 
            && (is_array($requestAll['filter']))
        ) 
        {
            $filter = $requestAll['filter'];

            if(array_key_exists('whereIn', $filter)) {
                $whereIn = $filter['whereIn'];
                if(array_key_exists('key', $whereIn) && 
                    array_key_exists('data', $whereIn)) {
                    $key = $whereIn['key'];
                    $data = $whereIn['data'];
                    if(array_key_exists('whereIn', $filter)) {
                        $model->whereIn($key, $data);
                    }
                }
                unset($filter['whereIn']);
            }
            foreach($filter as $key => $item){
                if(is_array($item)) {
                    $isDate = false;
                    if(array_key_exists('from', $item)){
                        $model->whereDate($key, '>=', $item['from']);
                        $isDate = true;
                    }
                    if(array_key_exists('to', $item)){
                        $model->whereDate($key, '<=', $item['to']);
                        $isDate = true;
                    }   

                    if(!$isDate && count($item)) {
                        $model->whereIn($key, $item);
                    }
                    unset($filter[$key]);
                }
            }
            $model->where($filter);
        }
        return $model;
    }
}