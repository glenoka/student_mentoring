<?php

namespace App\Filament\Resources\Assessments\Tables;

use App\Filament\Resources\Assessments\AssessmentsResource;
use App\Filament\Resources\Assessments\Pages\DoAssessment;
use App\Models\assessments;
use Filament\Actions\Action;
use Filament\Actions\ActionsServiceProvider;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class AssessmentsTable
{
    public static function configure(Table $table): Table
    {
        return $table
         ->emptyStateHeading('No assessments found.')
        ->defaultSort('created_at', 'desc')
            ->columns([
                TextColumn::make('student.name')->label('Student Name'),
                TextColumn::make('assessment_date')->label('Assessment Date')->date(),
                TextColumn::make('status')
                ->label('Status')
                ->badge(fn($state) => match ($state) {
                    'not_started' => 'secondary',
                    'finished' => 'success',
                })
                ->formatStateUsing(fn($record) => match ($record->status) {
                    'not_started' => 'Not Started',
                    'finished' => 'Finished',
                }),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                // EditAction::make()->hidden(fn(assessments $record): string => $record->status === 'finished'),
                ViewAction::make()->hidden(fn(assessments $record): string => $record->status === 'not_started'),
                Action::make('assessment')
                    ->label('Assessment')
                    ->icon('heroicon-o-document-text')
                    ->color('success')
                   ->hidden(fn(assessments $record): string => $record->status === 'finished')
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
