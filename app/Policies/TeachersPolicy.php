<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\Teachers;
use Illuminate\Auth\Access\HandlesAuthorization;

class TeachersPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:Teachers');
    }

    public function view(AuthUser $authUser, Teachers $teachers): bool
    {
        return $authUser->can('View:Teachers');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:Teachers');
    }

    public function update(AuthUser $authUser, Teachers $teachers): bool
    {
        return $authUser->can('Update:Teachers');
    }

    public function delete(AuthUser $authUser, Teachers $teachers): bool
    {
        return $authUser->can('Delete:Teachers');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:Teachers');
    }

    public function restore(AuthUser $authUser, Teachers $teachers): bool
    {
        return $authUser->can('Restore:Teachers');
    }

    public function forceDelete(AuthUser $authUser, Teachers $teachers): bool
    {
        return $authUser->can('ForceDelete:Teachers');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:Teachers');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:Teachers');
    }

    public function replicate(AuthUser $authUser, Teachers $teachers): bool
    {
        return $authUser->can('Replicate:Teachers');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:Teachers');
    }

}