<?php

namespace App\Filament\Resources\StudentTopics\Pages;

use App\Filament\Resources\StudentTopics\StudentTopicsResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListStudentTopics extends ListRecords
{
    protected static string $resource = StudentTopicsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            //CreateAction::make(),
        ];
    }
}
