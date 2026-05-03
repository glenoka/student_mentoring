<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\students;
use Illuminate\Auth\Access\HandlesAuthorization;

class studentsPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:Students');
    }

    public function view(AuthUser $authUser, students $students): bool
    {
        return $authUser->can('View:Students');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:Students');
    }

    public function update(AuthUser $authUser, students $students): bool
    {
        return $authUser->can('Update:Students');
    }

    public function delete(AuthUser $authUser, students $students): bool
    {
        return $authUser->can('Delete:Students');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:Students');
    }

    public function restore(AuthUser $authUser, students $students): bool
    {
        return $authUser->can('Restore:Students');
    }

    public function forceDelete(AuthUser $authUser, students $students): bool
    {
        return $authUser->can('ForceDelete:Students');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:Students');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:Students');
    }

    public function replicate(AuthUser $authUser, students $students): bool
    {
        return $authUser->can('Replicate:Students');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:Students');
    }

}