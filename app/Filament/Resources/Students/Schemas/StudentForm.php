<?php

namespace App\Filament\Resources\Students\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;


class StudentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Name')
                    ->required()
                    ->maxLength(255),
            TextInput::make('class')
                    ->label('Class')
                    ->required()
                    ->maxLength(255),
            Select::make('parent_id')
                   ->label('Parent')
                    ->options(function () {
                        return \App\Models\parents::pluck('name', 'id');
                    })
                    ->searchable()
                    ->preload()
                    ->required(),
            ]);
    }
}
