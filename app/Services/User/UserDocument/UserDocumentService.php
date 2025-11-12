<?php

namespace App\Services\User\UserDocument;
use App\Models\User\UserDocument;

class UserDocumentService
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
            $model = UserDocument::where(['deleted_at' => null]);
            
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
                ->with(['addedUser','addedUser.employeePosition'])
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
            return UserDocument::create($data);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
    public static function card($id){ 
        return UserDocument::where(['id' => $id])
            ->with(['addedUser'])
            ->first();    
    }
    public static function update($id, $data){ 
        try {
            UserDocument::where('id', $id)->update($data);
            return UserDocument::where('id', $id)->first();

        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
    public static function delete($id){ 
        try {
            return UserDocument::where('id', $id)->update(['deleted_at' => now()]);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
    public static function recover($id){ 
        try {
            return UserDocument::where('id', $id)->update(['deleted_at' => null]);
        } catch (Exception $e) {
            return $e->getMessage();
        }
     }
}