<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\StudentTopic;
use Illuminate\Auth\Access\HandlesAuthorization;

class StudentTopicPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:StudentTopic');
    }

    public function view(AuthUser $authUser, StudentTopic $studentTopic): bool
    {
        return $authUser->can('View:StudentTopic');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:StudentTopic');
    }

    public function update(AuthUser $authUser, StudentTopic $studentTopic): bool
    {
        return $authUser->can('Update:StudentTopic');
    }

    public function delete(AuthUser $authUser, StudentTopic $studentTopic): bool
    {
        return $authUser->can('Delete:StudentTopic');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:StudentTopic');
    }

    public function restore(AuthUser $authUser, StudentTopic $studentTopic): bool
    {
        return $authUser->can('Restore:StudentTopic');
    }

    public function forceDelete(AuthUser $authUser, StudentTopic $studentTopic): bool
    {
        return $authUser->can('ForceDelete:StudentTopic');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:StudentTopic');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:StudentTopic');
    }

    public function replicate(AuthUser $authUser, StudentTopic $studentTopic): bool
    {
        return $authUser->can('Replicate:StudentTopic');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:StudentTopic');
    }

}