<?php

namespace App\Filament\Resources\Assessments\Tables;

use App\Filament\Resources\Assessments\AssessmentsResource;
use App\Filament\Resources\Assessments\Pages\DoAssessment;
use Filament\Actions\Action;
use Filament\Actions\ActionsServiceProvider;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class AssessmentsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('student.name')->label('Student Name'),
                TextColumn::make('assessment_date')->label('Assessment Date')->date(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
                Action::make('assessment')
                    ->label('Assessment')
                    ->icon('heroicon-o-document-text')
                    ->color('success')
                    ->url(fn($record) => AssessmentsResource::getUrl('assessment',[
                        'record' => $record,
                    ]))
                    ->openUrlInNewTab(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
