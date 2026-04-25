<?php

namespace App\Filament\Resources\Topics\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class TopicsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')->label('Judul'),
                TextColumn::make('description')->label('Deskripsi')->limit(50),
                TextColumn::make('category')->label('Kategori')->formatStateUsing(fn (?string $state): string => match ($state) {
                    'math' => 'Matematika',
                    'language' => 'Bahasa',
                    default => 'Lainnya',
                })
                ->badge()
                ->color(fn (?string $state): string => match ($state) {
                    'math' => 'primary',
                    'language' => 'success',
                    default => 'secondary',
                }),
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
