<?php

namespace App\Filament\Resources\StudentTopics\Pages;

use App\Filament\Resources\StudentTopics\StudentTopicsResource;
use App\Models\mentoring_session;
use App\Models\student_topics;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Pages\Page;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Auth;

class MentoringSession extends Page
{
    protected static string $resource = StudentTopicsResource::class;

    protected string $view = 'filament.resources.student-topics.pages.mentoring-session';

    public $studentTopic;
    public string $activeTab = 'overview';
    public function mount($record): void
    {
        $studentTopic = student_topics::where('uuid', $record)->first();
        $sessionMentoringExists = mentoring_session::where('student_topic_id', $studentTopic->id)->exists();
        if (!$sessionMentoringExists) {
            $dataMentoringSession = [
                'student_topic_id' => $studentTopic->id,
                'user_id' => Auth::user()->id,
                'status' => 'in_progress',
                'session_date' => now(),
            ];
        }
        $this->studentTopic = student_topics::where('uuid', $record)->with('mentoringSessions', 'student', 'assessment', 'topic')->first();
    }



    public function mentoringInfolist(Schema $schema): Schema
    {
        return $schema
        ->record($this->studentTopic)
            ->schema([
                Tabs::make('Tabs')
                    ->tabs([
                        Tab::make('overview')
                            ->label('Overview')
                            ->icon('heroicon-o-eye')
                            ->schema([
                                Section::make('Student Information')
                                    ->schema([
                                TextEntry::make('student.name')
                                    ->label('Student Name'),

                                TextEntry::make('student.class')
                                    ->label('Class'),
                                    ])->columns(2),
                            ]),
                        Tab::make('mentoring_sessions')
            ->label('Mentoring Sessions')
            ->icon('heroicon-o-arrow-path')
                            ->schema([
                                // ...
                            ]),
                        Tab::make('Riwayat Mentoring')
                            ->label('Riwayat Mentoring')
                            ->icon('heroicon-o-clock')
                            ->schema([
                                // ...
                            ]),
                    ])->contained(false)
            ]);
    }
}
