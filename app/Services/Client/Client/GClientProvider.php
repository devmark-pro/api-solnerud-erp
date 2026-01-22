<?php
namespace App\Services\Client\Client;

use App\Models\User\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

        

class GClientProvider extends ServiceProvider
{
  
    public function boot(): void
    {
        Gate::define('client_r', function (User $user) {
            if(!isset($user->role->client_r)){
                return true;
            }
            return $user->role->client_r;
        });
        Gate::define('client_u', function (User $user) {
            if(!isset($user->role->client_u)){
                return true;
            }
            return $user->role->client_u;
        });
        Gate::define('client_c', function (User $user) {
            if(!isset($user->role->client_c)){
                return true;
            }
            return $user->role->client_c;
        });
        Gate::define('client_d', function (User $user) {
            if(!isset($user->role->client_d)){
                return true;
            }
            return $user->role->client_d;
        });
    }
}
