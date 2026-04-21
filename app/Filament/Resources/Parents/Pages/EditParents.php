<?php

namespace App\Filament\Resources\Parents\Pages;

use App\Filament\Resources\Parents\ParentsResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditParents extends EditRecord
{
    protected static string $resource = ParentsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
