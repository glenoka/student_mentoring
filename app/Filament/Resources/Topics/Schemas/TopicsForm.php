<?php

namespace App\Filament\Resources\Topics\Schemas;

use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class TopicsForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->label('Judul Topik')
                    ->required()
                    ->maxLength(255),
                Select::make('category')
                    ->label('Kategori Topik')
                    ->options([
                        'math' => 'Matematika',
                        'language' => 'Bahasa',
                    ])
                    ->required(),
                TextInput::make('type')
                    ->hidden()
                    ->default('doc'),
                RichEditor::make('description')
                    ->label('Deskripsi Topik')
                    ->extraAttributes([
                        'style' => 'min-height:300px'
                    ])
                    ->required(),
                RichEditor::make('achievement')
                    ->label('Pencapaian Topik')
                    ->extraAttributes([
                        'style' => 'min-height:300px'
                    ])
                    ->required(),
                RichEditor::make('strategy')
                ->extraAttributes([
                        'style' => 'min-height:300px'
                    ])
                    ->label('Strategi Topik'),
                TextInput::make('url')
                    ->label('URL Topik')
                    ->maxLength(255),
            ]);
    }
}
