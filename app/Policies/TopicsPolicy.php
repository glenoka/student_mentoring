<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\Topics;
use Illuminate\Auth\Access\HandlesAuthorization;

class TopicsPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:Topics');
    }

    public function view(AuthUser $authUser, Topics $topics): bool
    {
        return $authUser->can('View:Topics');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:Topics');
    }

    public function update(AuthUser $authUser, Topics $topics): bool
    {
        return $authUser->can('Update:Topics');
    }

    public function delete(AuthUser $authUser, Topics $topics): bool
    {
        return $authUser->can('Delete:Topics');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:Topics');
    }

    public function restore(AuthUser $authUser, Topics $topics): bool
    {
        return $authUser->can('Restore:Topics');
    }

    public function forceDelete(AuthUser $authUser, Topics $topics): bool
    {
        return $authUser->can('ForceDelete:Topics');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:Topics');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:Topics');
    }

    public function replicate(AuthUser $authUser, Topics $topics): bool
    {
        return $authUser->can('Replicate:Topics');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:Topics');
    }

}