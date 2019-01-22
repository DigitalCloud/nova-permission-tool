<?php

declare(strict_types=1);

namespace DigitalCloud\PermissionTool\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;

class RolePolicy
{
    use HandlesAuthorization;

    public function attachAnyPermission()
    {
         return true;
    }
    
    public function detachPermission()
    {
         return true;
    }
    
    public function attachAnyUser()
    {
         return true;
    }
    
    public function detachUser()
    {
         return true;
    }
    
    public function viewAny(): bool
    {
        return true;
    }

    public function view(): bool
    {
        return true;
    }

    public function create(): bool
    {
        return true;
    }

    public function update(): bool
    {
        return true;
    }

    public function delete(): bool
    {
        return true;
    }

    public function restore(): bool
    {
        return true;
    }

    public function forceDelete(): bool
    {
        return true;
    }
}
