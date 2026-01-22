<?php
namespace App\Services\Directory;

use App\Models\User\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

        

class GDirectoryProvider extends ServiceProvider
{
  
    public function boot(): void
    {
        Gate::define('directory_r', function (User $user) {
            if(!isset($user->role->directory_r)){
                return true;
            }
            return $user->role->directory_r;
        });
        Gate::define('directory_u', function (User $user) {
            if(!isset($user->role->directory_u)){
                return true;
            }
            return $user->role->directory_u;
        });
        Gate::define('directory_c', function (User $user) {
            if(!isset($user->role->directory_c)){
                return true;
            }
            return $user->role->directory_c;
        });
        Gate::define('directory_d', function (User $user) {
            if(!isset($user->role->directory_d)){
                return true;
            }
            return $user->role->directory_d;
        });
    }
}
