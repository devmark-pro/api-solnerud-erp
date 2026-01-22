<?php
namespace App\Services\Role;

use App\Models\User\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

        

class GRoleProvider extends ServiceProvider
{
  
    public function boot(): void
    {
        Gate::define('role_r', function (User $user) {
            if(!isset($user->role->role_r)){
                return true;
            }
            return $user->role->role_r;
        });
        Gate::define('role_u', function (User $user) {
            if(!isset($user->role->role_u)){
                return true;
            }
            return $user->role->role_u;
        });
        Gate::define('role_c', function (User $user) {
            if(!isset($user->role->role_c)){
                return true;
            }
            return $user->role->role_c;
        });
        Gate::define('role_d', function (User $user) {
            if(!isset($user->role->role_d)){
                return true;
            }
            return $user->role->role_d;
        });
    }
}
