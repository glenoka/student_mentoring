<?php

namespace App\Filament\Resources\Assessments\Pages;

use App\Filament\Resources\Assessments\AssessmentsResource;
use Filament\Resources\Pages\Page;

class DetailAssessment extends Page
{
    protected static string $resource = AssessmentsResource::class;

    protected string $view = 'filament.resources.assessments.pages.detail-assessment';
    
}
