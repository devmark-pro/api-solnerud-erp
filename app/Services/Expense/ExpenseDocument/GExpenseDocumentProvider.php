<?php
namespace App\Services\Expense\ExpenseDocument;

use App\Models\User\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

        

class GExpenseDocumentProvider extends ServiceProvider
{
  
    public function boot(): void
    {
        Gate::define('expenseDocument_r', function (User $user) {
            if(!isset($user->role->expenseDocument_r)){
                return true;
            }
            return $user->role->expenseDocument_r;
        });
        Gate::define('expenseDocument_u', function (User $user) {
            if(!isset($user->role->expenseDocument_u)){
                return true;
            }
            return $user->role->expenseDocument_u;
        });
        Gate::define('expenseDocument_c', function (User $user) {
            if(!isset($user->role->expenseDocument_c)){
                return true;
            }
            return $user->role->expenseDocument_c;
        });
        Gate::define('expenseDocument_d', function (User $user) {
            if(!isset($user->role->expenseDocument_d)){
                return true;
            }
            return $user->role->expenseDocument_d;
        });
    }
}
