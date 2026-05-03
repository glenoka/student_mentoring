<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\learning_materials;
use Illuminate\Auth\Access\HandlesAuthorization;

class learning_materialsPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:LearningMaterials');
    }

    public function view(AuthUser $authUser, learning_materials $learningMaterials): bool
    {
        return $authUser->can('View:LearningMaterials');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:LearningMaterials');
    }

    public function update(AuthUser $authUser, learning_materials $learningMaterials): bool
    {
        return $authUser->can('Update:LearningMaterials');
    }

    public function delete(AuthUser $authUser, learning_materials $learningMaterials): bool
    {
        return $authUser->can('Delete:LearningMaterials');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:LearningMaterials');
    }

    public function restore(AuthUser $authUser, learning_materials $learningMaterials): bool
    {
        return $authUser->can('Restore:LearningMaterials');
    }

    public function forceDelete(AuthUser $authUser, learning_materials $learningMaterials): bool
    {
        return $authUser->can('ForceDelete:LearningMaterials');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:LearningMaterials');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:LearningMaterials');
    }

    public function replicate(AuthUser $authUser, learning_materials $learningMaterials): bool
    {
        return $authUser->can('Replicate:LearningMaterials');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:LearningMaterials');
    }

}