<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\Questions;
use Illuminate\Auth\Access\HandlesAuthorization;

class QuestionsPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:Questions');
    }

    public function view(AuthUser $authUser, Questions $questions): bool
    {
        return $authUser->can('View:Questions');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:Questions');
    }

    public function update(AuthUser $authUser, Questions $questions): bool
    {
        return $authUser->can('Update:Questions');
    }

    public function delete(AuthUser $authUser, Questions $questions): bool
    {
        return $authUser->can('Delete:Questions');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:Questions');
    }

    public function restore(AuthUser $authUser, Questions $questions): bool
    {
        return $authUser->can('Restore:Questions');
    }

    public function forceDelete(AuthUser $authUser, Questions $questions): bool
    {
        return $authUser->can('ForceDelete:Questions');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:Questions');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:Questions');
    }

    public function replicate(AuthUser $authUser, Questions $questions): bool
    {
        return $authUser->can('Replicate:Questions');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:Questions');
    }

}