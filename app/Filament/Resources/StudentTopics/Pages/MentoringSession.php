<?php

namespace App\Filament\Resources\StudentTopics\Pages;

use App\Filament\Resources\StudentTopics\StudentTopicsResource;
use App\Models\mentoring_session;
use App\Models\student_topics;
use Carbon\Carbon;
use Filament\Actions\Action;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ToggleButtons;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Pages\Page;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;
use Filament\Support\Enums\TextSize;
use Illuminate\Support\Facades\Auth;


class MentoringSession extends Page implements HasForms
{
    use InteractsWithForms;
    protected static string $resource = StudentTopicsResource::class;

    protected string $view = 'filament.resources.student-topics.pages.mentoring-session';

    public $studentTopic;
    public $message;
   public ?array $session_details = [
    'message' => null,
    'progress_status' => 'developing',
];
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
                                Grid::make()
                                    ->schema([
                                        Section::make('Student Information')
                                            ->schema([
                                                TextEntry::make('student.name')
                                                    ->label('Student Name'),

                                                TextEntry::make('student.class')
                                                    ->label('Class'),
                                                TextEntry::make('assessment.assessment_date')
                                                    ->date()
                                                    ->label('Assessment Date'),
                                            ])->columns(2),

                                        Section::make('Learning Topic')
                                            ->description('Detail materi pembelajaran untuk sesi ini.')
                                            ->icon('heroicon-o-book-open')
                                            ->schema([

                                                TextEntry::make('topic.title')
                                                    ->label('Topic Title')
                                                    ->weight('bold')
                                                    ->size(TextSize::Large)
                                                    ->color('primary')
                                                    ->columnSpanFull(),



                                                Section::make('Description')
                                                    ->icon('heroicon-o-document-text')
                                                    ->compact()
                                                    ->schema([
                                                        TextEntry::make('topic.description')
                                                            ->hiddenLabel()
                                                            ->markdown()
                                                            ->columnSpanFull()
                                                            ->placeholder('-'),
                                                    ]),

                                                Section::make('Achievement Target')
                                                    ->icon('heroicon-o-trophy')
                                                    ->compact()
                                                    ->schema([
                                                        TextEntry::make('topic.achievement')
                                                            ->hiddenLabel()
                                                            ->markdown()
                                                            ->placeholder('-'),
                                                    ]),



                                                Section::make('Teaching Strategy')
                                                    ->icon('heroicon-o-light-bulb')
                                                    ->compact()
                                                    ->schema([
                                                        TextEntry::make('topic.strategy')
                                                            ->hiddenLabel()
                                                            ->markdown()
                                                            ->placeholder('-'),
                                                    ])
                                                    ->columnSpanFull(),

                                            ])
                                            ->columns(1)
                                            ->collapsible()
                                            ->persistCollapsed(),

                                    ])
                            ]),
                        Tab::make('mentoring_sessions')
                            ->label('Mentoring Sessions')
                            ->icon('heroicon-o-arrow-path')
                            ->schema([
                                Grid::make()
                                    ->schema([
                                        Section::make('Session Details')
                                            ->statePath('session_details')
                                            ->schema([

                                                RichEditor::make('message')
                                                    ->label('Catatan Mentoring')
                                                    ->placeholder('Tulis catatan mentoring di sini...')
                                                    ->extraAttributes([
                                                        'style' => 'min-height:200px',
                                                    ]),
                                                DatePicker::make('session_date')
                                                    ->label('Tanggal Sesi'),
                                                Select::make('progress_status')
                                                    ->label('Progress Belajar')
                                                    ->required()

                                                    ->default('developing')
                                                    ->options([
                                                        'pending_support' => 'Perlu Pendampingan',
                                                        'developing'      => 'Sedang Berkembang',
                                                        'reinforcement'   => 'Perlu Penguatan',
                                                        'progressing'     => 'Menunjukkan Perkembangan',
                                                        'good'            => 'Memahami dengan Baik',
                                                        'excellent'       => 'Sangat Baik',
                                                    ])

                                                    ->columnSpanFull(),
                                                Action::make('saveSession')
                                                    ->label('Simpan Catatan')
                                                    ->button()
                                                    ->icon('heroicon-m-chat-bubble-oval-left-ellipsis')
                                                    ->extraAttributes([
                                                        'class' => 'mt-4',
                                                    ])
                                                    ->action(function () {

                                                        dd($this->session_details,$this->message);
                                                    }),
                                            ]),


                                        Section::make('Session Notes')
                                            ->schema([
                                                // ...
                                            ])->columns(1),
                                    ])
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
