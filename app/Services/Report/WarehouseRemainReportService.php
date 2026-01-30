<?php

namespace App\Services\Report;
use App\Models\WarehouseRemains\WarehouseRemains;


class WarehouseRemainReportService
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
            $model = WarehouseRemains::where(['deleted_at' => null])
                ->where('actual_quantity', '<>', 0);
            $total = $model->get()->count();

            $model = self::find($model, $requestAll);
            $model = self::filter($model, $requestAll);

            // $modelList = $model;

            $modelTotal = clone $model;

              
            $count = $model->where(['deleted_at' => null])->get()->count();

            $pagesCount = ceil($count/$limit);

            $data = $model
                ->orderBy('created_at', 'desc')
                ->offset($offset)
                ->limit($limit)
                ->get();
            
            
          
            $total = $modelTotal->select(
                    \DB::raw('
                        sum(actual_quantity) as actual_quantity,
                        sum(reserve) as reserve,
                        sum(availability) as availability
                    '))
                ->first();
            
            return [
                'data_total' => [
                    'actual_quantity' => $total ? round($total->actual_quantity, 2) : 0,
                    'reserve' => $total ? round($total->reserve, 2) : 0,
                    'availability' => $total ? round($total->availability, 2) : 0,
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
            foreach($filter as $key=>$item){
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