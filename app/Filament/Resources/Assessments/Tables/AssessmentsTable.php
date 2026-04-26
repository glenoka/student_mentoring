<?php

namespace App\Filament\Resources\Assessments\Tables;

use App\Filament\Resources\Assessments\AssessmentsResource;
use App\Filament\Resources\Assessments\Pages\DoAssessment;
use App\Models\assessments;
use App\Models\student_topics;
use App\Models\topics;
use Filament\Actions\Action;
use Filament\Actions\ActionsServiceProvider;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class AssessmentsTable
{
    public $studentTopicId;
    public $data = [];


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
                    ->color(fn($state) => match ($state) {
                        'not_started' => 'primary',
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
                //ViewAction::make()->hidden(fn(assessments $record): string => $record->status === 'not_started'),
                Action::make('assessment')
                    ->label('Assessment')
                    ->icon('heroicon-o-document-text')
                    ->color('success')
                    ->hidden(fn(assessments $record): string => $record->status === 'finished')
                    ->url(fn($record) => AssessmentsResource::getUrl('assessment', [
                        'record' => $record,
                    ]))
                    ->openUrlInNewTab(),
                Action::make('detail')
                ->hidden(fn(assessments $record): string => $record->status === 'not_started')
                    ->label('Detail')
                    ->icon('heroicon-o-eye')
                    ->color('primary')
                    ->url(fn($record) => AssessmentsResource::getUrl('detail', [
                        'record' => $record,
                    ])),
                Action::make('topic')
                ->hidden(fn(assessments $record): string => $record->status === 'not_started')
                    ->fillForm(fn($record) => [
                        'topics' => student_topics::where('assessment_id', $record->id)
                            ->get()
                            ->map(fn($item) => [
                                'id' => $item->id,
                                'topic_id' => $item->topic_id,
                            ])
                            ->toArray(),
                    ])
                    ->label('Topik')
                    ->icon('heroicon-o-square-3-stack-3d')
                    ->color('info')
                    ->modalSubmitAction(false)
                    ->schema([
                        Repeater::make('topics')
                            ->label('Daftar Topik')
                            ->live()
                            ->schema([

                                Select::make('topic_id')
                                    ->label('Pilih Topik')
                                    ->options(topics::pluck('title', 'id')->toArray())
                                    ->searchable()
                                    ->disableOptionsWhenSelectedInSiblingRepeaterItems()
                                    ->live()
                                    ->afterStateUpdated(function ($state, $record, $get) {
                                        $studentTopicId = $get('id');
                                        student_topics::updateOrCreate(
                                            [
                                                'id' => $studentTopicId,
                                                'assessment_id' => $record->id,
                                            ],
                                            [
                                                'student_id'    => $record->student_id,
                                                //'assessment_id' => $record->id,
                                                'topic_id'      => $state,
                                                'status'        => 'not_started',
                                                'notes'         => null,
                                            ]
                                        );
                                        Notification::make()
                                            ->title('Topik berhasil disimpan')
                                            ->success()
                                            ->send();
                                    }),
                                Hidden::make('id'),
                            ])
                            ->deleteAction(
                                fn(Action $action) => $action
                                    ->requiresConfirmation()
                                    ->action(function ($arguments, $state, $set) {

                                        // ambil semua item repeater
                                        $items = $state;

                                        // ambil row yang dipilih
                                        $row = $items[$arguments['item']] ?? null;

                                        // hapus database
                                        if (!empty($row['id'])) {
                                            student_topics::where('id', $row['id'])->delete();
                                            Notification::make()
                                                ->title('Topik berhasil dihapus')
                                                ->success()
                                                ->send();
                                        }

                                        // hapus dari tampilan
                                        unset($items[$arguments['item']]);

                                        // rapikan index array
                                        $items = array_values($items);

                                        // update UI
                                        $set('topics', array_values($items));
                                    })
                            )
                            ->defaultItems(1)
                            ->addActionLabel('Tambah Topik')
                            ->columns(1),
                    ]),
            ])

            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
