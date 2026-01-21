<?php

namespace App\Services\Role;
use App\Models\Role;


class RoleObserver
{    
    public function created(Role $role): void
    {
       //
    }

    public function updated(Role $role): void
    {
        //
    }

    public function deleted(Role $role): void
    {
        //
    }

    public function restored(Role $role): void
    {
        //
    }

    public function forceDeleted(Role $role): void
    {
        //
    }
}
