<?php

namespace App\Filament\Resources\LearningMaterials\Pages;

use App\Filament\Resources\LearningMaterials\LearningMaterialResource;
use Filament\Resources\Pages\Page;

class ImageList extends Page
{
    protected static string $resource = LearningMaterialResource::class;

    protected string $view = 'filament.resources.learning-materials.pages.image-list';
}
