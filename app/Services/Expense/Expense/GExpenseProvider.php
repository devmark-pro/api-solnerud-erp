<?php
namespace App\Services\Expense\Expense;

use App\Models\User\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

        

class GExpenseProvider extends ServiceProvider
{
  
    public function boot(): void
    {
        Gate::define('expense_r', function (User $user) {
            if(!isset($user->role->expense_r)){
                return true;
            }
            return $user->role->expense_r;
        });
        Gate::define('expense_u', function (User $user) {
            if(!isset($user->role->expense_u)){
                return true;
            }
            return $user->role->expense_u;
        });
        Gate::define('expense_c', function (User $user) {
            if(!isset($user->role->expense_c)){
                return true;
            }
            return $user->role->expense_c;
        });
        Gate::define('expense_d', function (User $user) {
            if(!isset($user->role->expense_d)){
                return true;
            }
            return $user->role->expense_d;
        });
    }
}
