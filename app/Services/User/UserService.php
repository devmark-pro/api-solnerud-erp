<?php
namespace App\Services\User;
use App\Models\User;
use App\Models\Warehouse;

class UserService
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
            $model = User::where(['deleted_at' => null])
                ->with([
                    'employeePosition',
                    'employeeStatus',
                ]);
            
            $total = $model->get()->count();

            if(array_key_exists('find', $requestAll) 
                && (is_string($requestAll['find']))
            ) {

                $find = $requestAll['find']; 
                $model->where('id', 'LIKE', "%$find%")
                    ->orWhere('name', 'LIKE', "%$find%");
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
            $user = User::create($data);
            if(array_key_exists('warehouse_id', $data)){
                Warehouse::where('id', $data['warehouse_id'])
                    ->update(['user_id' => $user->id]);
                unset($data['warehouse_id']);
            };
            return $user;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
    public static function card($id){ 
        return User::where(['id' => $id])
            ->with([
                'employeePosition',
                'employeeStatus', 
            ])
            ->first();    
    }
    public static function update($id, $data){ 
        try {
            if(array_key_exists('warehouse_id', $data)){
                Warehouse::where('id', $data['warehouse_id'])
                    ->update(['user_id' => $id]);
                unset($data['warehouse_id']);
            }
            
            User::where('id', $id)->update($data);

            return User::where('id', $id)
                ->with([
                    'employeePosition',
                    'employeeStatus', 
                ])->first();

        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
    public static function delete($id){ 
        try {
            return User::where('id', $id)->update(['deleted_at' => now()]);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
    public static function recover($id){ 
        $model = User::find($id);
        if(!$model) return null; 
        return $model->update(['deleted_at' => null]);
    }

}