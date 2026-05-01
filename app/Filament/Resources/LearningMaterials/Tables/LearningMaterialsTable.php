<?php

namespace App\Filament\Resources\LearningMaterials\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class LearningMaterialsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('created_at','desc')
            ->columns([
                TextColumn::make('title')
                ->label('Title')
                ->sortable()
                ->searchable(),
                TextColumn::make('type')
                ->label('Type')
                ->badge()
                ->color(fn($state)=>match($state){
                    'video' =>'primary',
                    'game'=>'danger',
                    'image' => 'success',
                    'document' =>'warning'
                })

            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
