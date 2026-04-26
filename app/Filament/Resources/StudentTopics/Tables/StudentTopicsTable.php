<?php

namespace App\Filament\Resources\StudentTopics\Tables;

use App\Filament\Resources\StudentTopics\StudentTopicsResource;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Grouping\Group;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class StudentTopicsTable
{
    public static function configure(Table $table): Table
    {
        return $table
        ->defaultGroup('student.name')
        ->groups([
            Group::make('student.name')
                ->label('Nama Siswa')
                ->collapsible(),
        ])
        
            ->columns([
                TextColumn::make('student.name')->label('Student Name')
                ->sortable()
                ->searchable(),
                TextColumn::make('student.class')->label('Class'),
                TextColumn::make('topic.title')->label('Topic Name')
                ->sortable()
                ->searchable(),
                TextColumn::make('assessment.assessment_date')->label('Assessment Date')->date()
                ->sortable(),
            ])
            
            ->filters([
                //
            ])
            ->recordActions([
                //EditAction::make(),
                Action::make('start')
                ->label('Start')
                ->icon('heroicon-o-play')
                ->color('success')
                ->visible(fn ($record) => blank($record->mentoringSessions))
                ->url(fn($record) => StudentTopicsResource::getUrl('mentoring-session', [
                        'record' => $record,
                    ])),
                Action::make('Open Assessment')
                    ->label('Open')
                    ->icon('heroicon-o-document-text')
                    ->color('primary') 
                    ->visible(fn ($record) => filled($record->mentoringSessions))
                    ->url(fn($record) => StudentTopicsResource::getUrl('mentoring-session', [
                        'record' => $record,
                    ])),
                    

            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
