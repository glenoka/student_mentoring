<?php

namespace App\Filament\Resources\Questions\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class QuestionsForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('question_text')
                    ->label('Question')
                    ->required()
                    ->maxLength(255),
                Select::make('type')
                    ->label('Type')
                    ->options([
                        'boolean' => 'Options',
                        'numeric' => 'Numeric',
                    ])
                    ->required(),
                TextInput::make('order_number')
                    ->label('Order Number')
                    ->numeric()
                    ->required(),
            ]);
    }
}
