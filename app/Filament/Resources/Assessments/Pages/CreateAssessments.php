<?php

namespace App\Filament\Resources\Assessments\Pages;

use App\Filament\Resources\Assessments\AssessmentsResource;
use App\Models\assessments;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;

class CreateAssessments extends CreateRecord
{
    protected static string $resource = AssessmentsResource::class;

    public function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    public function mutateFormDataBeforeCreate(array $data): array
    {
        $student_id = $data['student_id'];
        $checkExistingAssessment = assessments::where('student_id', $student_id)->exists();
       
        if ($checkExistingAssessment) {
           Notification::make()
                ->title('An assessment for this student already exists.')
                ->danger()
                ->send();

          $this->halt();
           
        }
        return $data;
    }
}
