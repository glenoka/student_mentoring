<?php

namespace App\Filament\Parent\Pages;

use App\Models\Parents;
use App\Models\Student;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Pages\Page;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Auth;


class StudentView extends Page implements HasSchemas
{
    use InteractsWithSchemas;

    protected string $view = 'filament.parent.pages.student-view';

    public array $data = [];
    public $student;
    public function mount(): void
    {
        $parentID = Parents::where('user_id', Auth::user()->id)->first();

        $this->student = Student::where('parent_id', $parentID->id)
            ->with('assessments.answers.question', 'studentTopics.topic', 'studentTopics.mentoringSessions.comments')
            ->first();

        //dd($this->student);



        // Fill data as array for the schema
        $this->data = $this->student?->toArray() ?? [];
    }

    public function studentDetail(Schema $schema): Schema
    {

        return $schema
            ->record($this->student)
            ->components([
                Section::make('Informasi Siswa')
                    ->description('Detail data siswa dan assessment terbaru')
                    ->icon('heroicon-o-academic-cap')
                    ->schema([
                        TextEntry::make('name')
                            ->label('Nama Siswa')
                            ->weight('bold'),

                        TextEntry::make('class')
                            ->label('Kelas')
                            ->badge()
                            ->color('primary'),

                        TextEntry::make('assessments.status')
                            ->label('Status Assessment')
                            ->badge()
                            ->color(fn(?string $state): string => match ($state) {
                                'finished' => 'success',
                                'on_progress' => 'warning',
                                default => 'gray',
                            })
                            ->formatStateUsing(fn(?string $state): string => match ($state) {
                                'finished' => 'Finished',
                                'on_progress' => 'On Progress',
                            }),

                        TextEntry::make('assessments.assessment_date')
                            ->label('Tanggal Assessment')
                            ->date('d M Y'),
                    ])
                    ->columns(2)
                    ->collapsible(),
                Section::make('Topic')
                      ->description('Detail topik yang diambil')
                    ->schema([
                        RepeatableEntry::make('studentTopics')
                            ->label('Progress Pembelajaran')
                            ->contained(false)
                            ->schema([

                                Section::make(fn($record) => $record->topic?->title ?? 'Topik')
                                    ->description('Detail perkembangan pembelajaran siswa')
                                    ->icon('heroicon-o-academic-cap')
                                    ->collapsed()
                                    ->schema([

                                        TextEntry::make('mentoringSessions.status')
                                            ->label('Status')
                                            ->badge()
                                            ->default('Not Yet')
                                            ->formatStateUsing(fn(?string $state): string => match ($state) {
                                                'done' => 'Finished',
                                                'in_progress' => 'In Progress',
                                                default => 'Not Yet',
                                            })
                                            ->color(fn(?string $state): string => match ($state) {
                                                'compdoneleted' => 'success',
                                                'in_progress' => 'warning',
                                              
                                                default => 'gray',
                                            }),

                                        TextEntry::make('mentoringSessions.session_date')
                                            ->label('Tanggal Sesi')
                                            ->date('d M Y')
                                          ->visible(fn ($state) => filled($state))
                                            ->icon('heroicon-o-calendar-days'),

                                        TextEntry::make('comments_count')
                                            ->label('Komentar')
                                            ->state(
                                                fn($record) =>
                                                $record->mentoringSessions?->comments()->count() ?? 0
                                            )
                                            ->badge()
                                            ->color('info')
                                            ->icon('heroicon-o-chat-bubble-left-right')
                                            ->formatStateUsing(fn($state) => $state . ' Komentar')
                                            ->columnSpanFull(),

                                    ])
                                    ->columns(2)
                                    ->collapsible(),

                            ]),
                    ])
            ]);
    }


}
