<?php

namespace App\Filament\Resources\StudentTopics\Pages;

use App\Filament\Resources\StudentTopics\StudentTopicsResource;
use App\Models\mentoring_comments;
use App\Models\mentoring_session;
use App\Models\student_topics;
use App\Models\User;
use Carbon\Carbon;
use Filament\Actions\Action;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ToggleButtons;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Infolists\Components\TextEntry;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\Page;
use Filament\Schemas\Components\Actions;
use Filament\Schemas\Components\Form;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\View;
use Filament\Schemas\Schema;
use Filament\Support\Enums\TextSize;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Facades\Auth;
use Tiptap\Editor;


class MentoringSession extends Page implements HasForms
{
    use InteractsWithForms;
    protected static string $resource = StudentTopicsResource::class;

    protected string $view = 'filament.resources.student-topics.pages.mentoring-session';

    public $studentTopic;
    public $teacher;
    public array $sessions = [];
    public ?array $data = [];
    public $lastSession;

    public ?array $session_details = [
        'message' => '',
        'progress_status' => 'progressing',

    ];
    public string $activeTab = 'overview';
    public function mount($record): void
    {
        $studentTopic = student_topics::where('uuid', $record)->with('mentoringSessions.comments')->first();
        $this->lastSession = $studentTopic?->mentoringSessions?->comments
            ?->whereNull('parent_comment_id')
            ->sortByDesc('created_at')
            ->first();

        $sessionMentoringExists = mentoring_session::where('student_topic_id', $studentTopic->id)->exists();

        if (!$sessionMentoringExists) {
            $dataMentoringSession = [
                'student_topic_id' => $studentTopic->id,
                'user_id' => Auth::user()->id,
                'status' => 'in_progress',
                'session_date' => now(),
            ];
            $createSession = mentoring_session::create($dataMentoringSession);
            $studentTopic->update([
                'status' => 'in_progress',
            ]);
        }
        $this->studentTopic = student_topics::where('uuid', $record)->with('mentoringSessions', 'student', 'assessment', 'topic')->first();
        $this->teacher = User::where('id', Auth::user()->id)->with('teacher')->first();

        $this->loadSessions();
        //dd($this->loadSessions());
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('finish_mentoring')
                ->label('Mentoring Selesai')
                ->icon(Heroicon::ShieldCheck)
                ->color('success')
               ->hidden(fn () => $this->studentTopic?->status === 'completed')
                ->schema([
                    Textarea::make('note')
                        ->label('Catatan Akhir'),
                ])

                ->requiresConfirmation()
                ->modalHeading('Mentoring Selesai')
                ->modalDescription('Apakah kamu yakin akan mengakhiri Sesi Mentoring ini?')
                ->modalSubmitActionLabel('Simpan & Akhiri')

                ->action(function (array $data): void {
                    $dataUpdate = [
                        'notes' => $data['note'],
                        'end_date' => now(),
                        'status' => 'done',
                    ];
                    $mentoringSessionUpdate = mentoring_session::where(
                        'student_topic_id',
                        $this->studentTopic->id
                    )->update($dataUpdate);

                    $this->studentTopic->update([
                        'status' => 'completed',
                    ]);
                }),
        ];
    }

    public function loadSessions(): array
    {
        $sessionId = $this->studentTopic->mentoringSessions?->id;

        if (!$sessionId) {
            return $this->sessions = [];
        }

        $this->lastSession = mentoring_comments::query()
            ->where('mentoring_session_id', $sessionId)
            ->whereNull('parent_comment_id')
            ->latest()
            ->first();

        return $this->sessions = mentoring_comments::query()
            ->with(['teacher.user', 'parent.user', 'replies'])
            ->withCount('replies')
            ->where('mentoring_session_id', $sessionId)
            ->whereNull('parent_comment_id')
            ->latest()
            ->get()
            ->map(function ($item) {
                if ($item->parent_id == null) {
                    $mentorName = $item->teacher->name;
                } else {
                    $mentorName = $item->parent->name;
                }


                return [
                    'id' => $item->id,
                    'session_date' => $item->created_at?->format('Y-m-d'),
                    'progress_status' => $item->progress_status,
                    'mentor' => $mentorName,
                    'duration' => '45 Menit',
                    'message' => $item->message,
                    'comment_count' => $item->replies_count,
                ];
            })
            ->toArray();
    }


    public function mentoring(Schema $schema): Schema
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
                                                TextEntry::make('mentoringSessions.status')
                                                    ->label('Status')
                                                    ->badge()
                                                    ->color(fn($state) => match ($state) {

                                                        'in_progress' => 'warning',
                                                        'done' => 'success',
                                                        default => 'gray',
                                                    })
                                                    ->formatStateUsing(fn(string $state) => match ($state) {

                                                        'in_progress' => 'In Progress',
                                                        'done' => 'Completed',
                                                        default => 'gray',
                                                    }),
                                                TextEntry::make('lastSession')
                                                    ->label('Pertemuan Terakhir')
                                                    ->live()
                                                    ->badge()
                                                    ->color('info')
                                                    ->getStateUsing(
                                                        fn() =>
                                                        $this->lastSession?->created_at?->diffForHumans() ?? 'Belum ada sesi'
                                                    )
                                                    ->live()
                                                    ->default('Belum ada sesi'),
                                                TextEntry::make('mentoringSessions.session_date')
                                                    ->date()
                                                    ->label('Tanggal Mulai'),
                                                
                                                TextEntry::make('mentoringSessions.end_date')
                                                    ->date()
                                                    ->hidden(fn () => $this->studentTopic?->status === 'on_progress')
                                                    ->label('Tanggal Selesai')
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
                                              ->hidden(fn () => $this->studentTopic?->status === 'completed')
                                            ->statePath('session_details')
                                            ->schema([
                                                TextEntry::make('topic.title')
                                                    ->label('Topic Title')
                                                    ->color('primary')
                                                    ->inlineLabel()
                                                    ->columnSpanFull(),
                                                RichEditor::make('message')
                                                    ->label('Catatan Mentoring')
                                                    ->toolbarButtons([
                                                        ['bold', 'italic', 'underline', 'strike', 'subscript', 'superscript', 'link'],
                                                        ['h2', 'h3'],
                                                        ['blockquote', 'bulletList', 'orderedList'],
                                                    ])
                                                    ->placeholder('Tulis catatan mentoring di sini...')
                                                    ->extraAttributes([
                                                        'style' => 'min-height:300px',
                                                    ]),
                                                Select::make('progress_status')
                                                    ->label('Progress Belajar')
                                                    ->required()

                                                    ->default('developing')
                                                    ->options([
                                                        'pending_support' => 'Perlu Pendampingan',
                                                        'developing' => 'Sedang Berkembang',
                                                        'reinforcement' => 'Perlu Penguatan',
                                                        'progressing' => 'Menunjukkan Perkembangan',
                                                        'good' => 'Memahami dengan Baik',
                                                        'excellent' => 'Sangat Baik',
                                                    ])

                                                    ->columnSpanFull(),
                                                TextInput::make('mentoring_session_id')
                                                    ->hidden(),

                                                Action::make('saveSession')
                                                    ->label('Simpan Catatan')
                                                    ->button()
                                                    ->icon('heroicon-m-chat-bubble-oval-left-ellipsis')
                                                    ->extraAttributes([
                                                        'class' => 'mt-4',
                                                    ])
                                                    ->action(function ($data) {
                                                        $json = $this->session_details['message'];
                                                        $editor = new Editor();
                                                        $html = $editor->setContent($json)->getHTML();

                                                        $dataCreate = [
                                                            'mentoring_session_id' => $this->studentTopic->mentoringSessions->id,
                                                            'message' => $html,
                                                            'teacher_id' => $this->teacher->teacher->id,
                                                            'progress_status' => $this->session_details['progress_status'] ?? null,
                                                        ];

                                                        $editId = $this->session_details['mentoring_session_id'] ?? null;

                                                        if ($editId) {
                                                            $createComment = mentoring_comments::find($editId)?->update([
                                                                'message' => $html,
                                                                'progress_status' => $this->session_details['progress_status'] ?? null,
                                                            ]);
                                                        } else {
                                                            $createComment = mentoring_comments::create($dataCreate);
                                                        }
                                                        if ($createComment) {
                                                            $this->session_details = [];
                                                            Notification::make()
                                                                ->title('Saved successfully')
                                                                ->success()
                                                                ->send();
                                                            $this->loadSessions();
                                                        }
                                                    }),
                                            ]),


                                        Section::make('Session Notes')
                                            
                                            ->schema([
                                                View::make('filament.resources.student-topics.pages.timeline-mentoring')

                                            ])->columns(1),
                                    ])
                            ]),

                    ])->contained(false)
            ]);
    }

    public function editSession($id)
    {

        $getComment = mentoring_comments::find($id);

        $this->session_details = [
            'message' => $getComment->message,
            'progress_status' => $getComment->progress_status,
            'mentoring_session_id' => $getComment->id,
        ];
    }

    // Tambahkan sebagai method yang return Action
    public function deleteSessionAction(): Action
    {
        return Action::make('deleteSession')
            ->requiresConfirmation()
            ->modalHeading('Hapus Catatan')
            ->modalDescription('Apakah kamu yakin ingin menghapus catatan ini? Tindakan ini tidak bisa dibatalkan.')
            ->modalSubmitActionLabel('Ya, Hapus')
            ->color('danger')
            ->action(function (array $arguments) {
                mentoring_comments::find($arguments['id'])?->delete();

                Notification::make()
                    ->title('Deleted successfully')
                    ->success()
                    ->send();

                $this->loadSessions();
            });
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->statePath('data')
            ->schema([
                Textarea::make('message')
                    ->label('Balasan Guru')
                    ->placeholder('Tulis balasan...')
                    ->rows(4)
                    ->hidden(fn () => $this->studentTopic?->status === 'completed')
                    ->required()
                    ->maxLength(1000),
            ]);
    }

    public function sendReply($id)
    {
      
        $parent = mentoring_comments::findOrFail($id);

        mentoring_comments::create([
            'mentoring_session_id' => $parent->mentoring_session_id,
            'parent_comment_id' => $id,
            'teacher_id' => $this->teacher->id,
            'message' => $this->data['message'],
        ]);



        $this->loadSessions();
        $this->form->fill(); // reset aman
    }
}
