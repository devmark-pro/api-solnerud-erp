<?php
namespace App\Services\Sale\Sale;

use App\Models\User\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

        

class GSaleProvider extends ServiceProvider
{
  
    public function boot(): void
    {
        Gate::define('sale_r', function (User $user) {
            if(!isset($user->role->sale_r)){
                return true;
            }
            return $user->role->sale_r;
        });
        Gate::define('sale_u', function (User $user) {
            if(!isset($user->role->sale_u)){
                return true;
            }
            return $user->role->sale_u;
        });
        Gate::define('sale_c', function (User $user) {
            if(!isset($user->role->sale_c)){
                return true;
            }
            return $user->role->sale_c;
        });
        Gate::define('sale_d', function (User $user) {
            if(!isset($user->role->sale_d)){
                return true;
            }
            return $user->role->sale_d;
        });
    }
}
