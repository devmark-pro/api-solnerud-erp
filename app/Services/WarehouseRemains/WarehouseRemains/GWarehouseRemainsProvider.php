<?php
namespace App\Services\WarehouseRemains\WarehouseRemains;

use App\Models\User\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

        

class GWarehouseRemainsProvider extends ServiceProvider
{
  
    public function boot(): void
    {
        Gate::define('warehouse_remains_r', function (User $user) {
            if(!isset($user->role->warehouse_r)){
                return false;
            }
            return $user->role->warehouse_r;
        });
        Gate::define('warehouse_remains_u', function (User $user) {
            if(!isset($user->role->warehouse_u)){
                return false;
            }
            return $user->role->warehouse_u;
        });
        Gate::define('warehouse_remains_c', function (User $user) {
            if(!isset($user->role->warehouse_c)){
                return false;
            }
            return $user->role->warehouse_c;
        });
        Gate::define('warehouse_remains_d', function (User $user) {
            if(!isset($user->role->warehouse_d)){
                return false;
            }
            return $user->role->warehouse_d;
        });
    }
}
