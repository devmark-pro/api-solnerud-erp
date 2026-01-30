<?php
namespace App\Services\Report;

use App\Models\User\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

        

class GReportProvider extends ServiceProvider
{
  
    public function boot(): void
    {
        Gate::define('report_r', function (User $user) {
            if(!isset($user->role->report_r)){
                return true;
            }
            return $user->role->report_r;
        });
    }
}
