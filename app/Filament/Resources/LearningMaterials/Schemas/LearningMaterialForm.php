<?php

namespace App\Filament\Resources\LearningMaterials\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class LearningMaterialForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->label('Title')
                    ->required()
                    ->maxLength(255),

                Select::make('type')
                    ->label('Type')
                    ->options([
                        'document' => 'Document',
                        'image' => 'Image',
                        'video' => 'Video',
                        'game' => 'Game',
                    ])
                    ->required()
                    ->reactive(),

                /*
    |--------------------------------------------------------------------------
    | DOCUMENT
    |--------------------------------------------------------------------------
    */
                TextInput::make('url')
                    ->label('Document URL')
                    ->url()
                    ->columnSpanFull()
                    ->visible(fn($get) => $get('type') === 'document'),

                /*
    |--------------------------------------------------------------------------
    | IMAGE (REPEATER)
    |--------------------------------------------------------------------------
    */
                Section::make('Images')
                    ->schema([
                        Repeater::make('images')
                            ->relationship('images')
                            ->schema([
                                FileUpload::make('image_url')
                                    ->label('Upload Image')
                                    ->image()
                                    ->directory('materials/images')
                                    ->required(),

                                Textarea::make('description')
                                    ->label('Description')
                                    ->rows(2),
                            ])
                            ->columns(2)
                            ->minItems(1)
                            ->collapsible(),
                    ])
                    ->columnSpanFull()
                    ->visible(fn($get) => $get('type') === 'image'),

                /*
    |--------------------------------------------------------------------------
    | VIDEO (REPEATER)
    |--------------------------------------------------------------------------
    */
                Section::make('Videos')
                    ->schema([
                        Repeater::make('videos')
                            ->relationship('videos')
                            ->schema([
                                TextInput::make('video_url')
                                    ->label('Video URL')
                                    ->url()
                                    ->required(),

                                Textarea::make('description')
                                    ->label('Description')
                                    ->rows(2),
                            ])
                            ->columns(2)
                            ->minItems(1)
                            ->collapsible(),
                    ])
                    ->columnSpanFull()
                    ->visible(fn($get) => $get('type') === 'video'),

                /*
    |--------------------------------------------------------------------------
    | GAME
    |--------------------------------------------------------------------------
    */
                TextInput::make('url')
                    ->label('Game URL')
                    ->url()
                    ->columnSpanFull()
                    ->visible(fn($get) => $get('type') === 'game'),
            ]);
    }
}
