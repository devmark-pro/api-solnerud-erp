<?php

namespace App\Services\Report;
use App\Models\Sale\Sale;


class SaleReportService
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
            $model = Sale::where(['deleted_at' => null]);
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

            return [
                // 'data_total' => $total,
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
            $model->where($filter);
        }
        return $model;
    }
}