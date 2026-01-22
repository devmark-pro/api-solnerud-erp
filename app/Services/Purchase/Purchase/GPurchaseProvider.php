<?php
namespace App\Services\Purchase\Purchase;

use App\Models\User\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

        

class GPurchaseProvider extends ServiceProvider
{
  
    public function boot(): void
    {
        Gate::define('purchase_r', function (User $user) {
            if(!isset($user->role->purchase_r)){
                return true;
            }
            return $user->role->purchase_r;
        });
        Gate::define('purchase_u', function (User $user) {
            if(!isset($user->role->purchase_u)){
                return true;
            }
            return $user->role->purchase_u;
        });
        Gate::define('purchase_c', function (User $user) {
            if(!isset($user->role->purchase_c)){
                return true;
            }
            return $user->role->purchase_c;
        });
        Gate::define('purchase_d', function (User $user) {
            if(!isset($user->role->purchase_d)){
                return true;
            }
            return $user->role->purchase_d;
        });
    }
}
