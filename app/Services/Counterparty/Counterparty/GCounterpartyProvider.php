<?php
namespace App\Services\Counterparty\Counterparty;

use App\Models\User\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

        

class GCounterpartyProvider extends ServiceProvider
{
  
    public function boot(): void
    {
        Gate::define('counterparty_r', function (User $user) {
            if(!isset($user->role->counterparty_r)){
                return true;
            }
            return $user->role->counterparty_r;
        });
        Gate::define('counterparty_u', function (User $user) {
            if(!isset($user->role->counterparty_u)){
                return true;
            }
            return $user->role->counterparty_u;
        });
        Gate::define('counterparty_c', function (User $user) {
            if(!isset($user->role->counterparty_c)){
                return true;
            }
            return $user->role->counterparty_c;
        });
        Gate::define('counterparty_d', function (User $user) {
            if(!isset($user->role->counterparty_d)){
                return true;
            }
            return $user->role->counterparty_d;
        });
    }
}
