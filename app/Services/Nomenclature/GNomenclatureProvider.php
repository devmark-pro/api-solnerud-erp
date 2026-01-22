<?php
namespace App\Services\Nomenclature;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use App\Models\User\User;

        

class GNomenclatureProvider extends ServiceProvider
{
  
    public function boot(): void
    {
        Gate::define('nomenclature_r', function (User $user) {
            if(!isset($user->role->nomenclature_r)){
                return false;
            }
            return $user->role->nomenclature_r;
        });
        Gate::define('nomenclature_u', function (User $user) {
            if(!isset($user->role->nomenclature_u)){
                return false;
            }
            return $user->role->nomenclature_u;
        });
        Gate::define('nomenclature_c', function (User $user) {
            if(!isset($user->role->nomenclature_c)){
                return false;
            }
            return $user->role->nomenclature_c;
        });
        Gate::define('nomenclature_d', function (User $user) {
            if(!isset($user->role->nomenclature_d)){
                return false;
            }
            return $user->role->nomenclature_d;
        });
    }
}
