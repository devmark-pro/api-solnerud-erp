<?php
namespace App\Services\Counterparty\Counterparty;
use App\Models\Counterparty\Counterparty;

class CounterpartyService
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
            $model = Counterparty::where(['deleted_at' => null])
                ->with(['counterpartyType','representatives']);

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
               
            $dataTotal = Counterparty::select('counterparty_type_id',
                    \DB::raw('
                        count(*) as count
                    '))
                ->where(['deleted_at' => null])
                ->with(['counterpartyType'])
                ->groupBy('counterparty_type_id')
                ->get();    

            return [
                'data_total'=> $dataTotal,
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
        try{
            return Counterparty::create($data);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
    public static function card($id){ 
        return Counterparty::where(['id' => $id])
            ->with(['counterpartyType', 'representatives'])
            ->first();    
    }
    public static function update($id, $data){ 
        try {
            Counterparty::where('id', $id)->update($data);
            return Counterparty::where('id', $id)
                ->with(['counterpartyType', 'representatives'])
                ->first();
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
    public static function delete($id){ 
        $model = Counterparty::find($id);
        if(!$model) return null; 
        return $model->update(['deleted_at' => now()]); 
    }
    public static function recover($id){ 
        $model = Counterparty::find($id);
        if(!$model) return null; 
        return $model->update(['deleted_at' => null]);
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
            foreach($filter as $key=>$item){
                if(is_array($item)) {
                    if(count($item)) {
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