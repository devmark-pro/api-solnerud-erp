<?php
namespace App\Services\User\User;

use App\Models\User\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

        

class GUserProvider extends ServiceProvider
{
  
    public function boot(): void
    {
        Gate::define('user_r', function (User $user) {
            if(!isset($user->role->user_r)){
                return true;
            }
            return $user->role->user_r;
        });
        Gate::define('user_u', function (User $user) {
            if(!isset($user->role->user_u)){
                return true;
            }
            return $user->role->user_u;
        });
        Gate::define('user_c', function (User $user) {
            if(!isset($user->role->user_c)){
                return true;
            }
            return $user->role->user_c;
        });
        Gate::define('user_d', function (User $user) {
            if(!isset($user->role->user_d)){
                return true;
            }
            return $user->role->user_d;
        });
    }
}
