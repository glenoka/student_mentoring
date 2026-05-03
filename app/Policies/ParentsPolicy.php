<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\Parents;
use Illuminate\Auth\Access\HandlesAuthorization;

class ParentsPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:Parents');
    }

    public function view(AuthUser $authUser, Parents $parents): bool
    {
        return $authUser->can('View:Parents');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:Parents');
    }

    public function update(AuthUser $authUser, Parents $parents): bool
    {
        return $authUser->can('Update:Parents');
    }

    public function delete(AuthUser $authUser, Parents $parents): bool
    {
        return $authUser->can('Delete:Parents');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:Parents');
    }

    public function restore(AuthUser $authUser, Parents $parents): bool
    {
        return $authUser->can('Restore:Parents');
    }

    public function forceDelete(AuthUser $authUser, Parents $parents): bool
    {
        return $authUser->can('ForceDelete:Parents');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:Parents');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:Parents');
    }

    public function replicate(AuthUser $authUser, Parents $parents): bool
    {
        return $authUser->can('Replicate:Parents');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:Parents');
    }

}