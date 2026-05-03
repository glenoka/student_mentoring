<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\student_topics;
use Illuminate\Auth\Access\HandlesAuthorization;

class student_topicsPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:StudentTopics');
    }

    public function view(AuthUser $authUser, student_topics $studentTopics): bool
    {
        return $authUser->can('View:StudentTopics');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:StudentTopics');
    }

    public function update(AuthUser $authUser, student_topics $studentTopics): bool
    {
        return $authUser->can('Update:StudentTopics');
    }

    public function delete(AuthUser $authUser, student_topics $studentTopics): bool
    {
        return $authUser->can('Delete:StudentTopics');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:StudentTopics');
    }

    public function restore(AuthUser $authUser, student_topics $studentTopics): bool
    {
        return $authUser->can('Restore:StudentTopics');
    }

    public function forceDelete(AuthUser $authUser, student_topics $studentTopics): bool
    {
        return $authUser->can('ForceDelete:StudentTopics');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:StudentTopics');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:StudentTopics');
    }

    public function replicate(AuthUser $authUser, student_topics $studentTopics): bool
    {
        return $authUser->can('Replicate:StudentTopics');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:StudentTopics');
    }

}