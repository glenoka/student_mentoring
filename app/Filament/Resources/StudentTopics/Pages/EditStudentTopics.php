<?php

namespace App\Filament\Resources\StudentTopics\Pages;

use App\Filament\Resources\StudentTopics\StudentTopicsResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditStudentTopics extends EditRecord
{
    protected static string $resource = StudentTopicsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
