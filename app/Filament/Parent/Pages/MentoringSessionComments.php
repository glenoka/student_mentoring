<?php

namespace App\Filament\Parent\Pages;

use App\Models\MentoringComment;
use App\Models\MentoringSession as MentoringSessionModel;
use App\Models\Parents;
use App\Models\StudentTopic;
use BackedEnum;
use Date;
use Filament\Actions\Action;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Infolists\Components\TextEntry;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Components\View;
use Filament\Schemas\Schema;
use Filament\Support\Enums\TextSize;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Facades\Auth;
use Tiptap\Editor;

class MentoringSessionComments extends Page
{
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCheckBadge;
  public $studentTopic;
    public array $sessions = [];
    public ?array $data = [];
    public $lastSession;
    public $parent;
    public ?array $session_details = [
        'message' => '',
        'progress_status' => 'progressing',

    ];
  protected static ?string $navigationLabel = 'Parent Mentoring';
  protected static ?string $pluralModelLabel = 'Parent Mentoring';
    protected static ?string $title = 'Mentoring Session Comments';

    protected string $view = 'filament.parent.pages.mentoring-session-comments';
    protected static bool $shouldRegisterNavigation = false;
    public function mount()
    {   
        
        $uuid = request()->query('uuid');
    
        $this->parent = Parents::where('user_id', Auth::user()->id)->first();
        $this->studentTopic = StudentTopic::where('uuid', $uuid)->with('mentoringSessions.comments')->first();
        
        if($this->studentTopic->mentoringSessions==null){
            $dataMentoringSession = [
                'student_topic_id' => $this->studentTopic->id,
                'user_id' => Auth::user()->id,
                'status' => 'in_progress',
                'session_date' => now(),
            ];
            $createSession = MentoringSessionModel::create($dataMentoringSession);
            $this->studentTopic->update([
                'status' => 'in_progress',
            ]);
        } 
        $this->loadSessions();
    
    }

//    protected function getHeaderActions(): array
// {
//     return [

//         Action::make('newSession')
//             ->label('New Session')
//             ->icon('heroicon-m-plus')
//             ->modalHeading('Buat Session Mentoring')
//             ->modalSubmitActionLabel('Simpan')
//             ->form([
//                 DatePicker::make('session_date')
//                     ->label('Tanggal Sesi')
//                     ->required()
//                     ->default(now()),
//                 RichEditor::make('message')
//                     ->label('Comment / Catatan')
//                     ->required()
//                     ->placeholder('Masukkan catatan mentoring...')
//                     ->columnSpanFull(),

//             ])

//             ->action(function (array $data) {

//                 MentoringComment::create([
//                     'message' => $data['message'],
//                     'mentoring_session_id' => $this->studentTopic->mentoringSessions->id,
//                     'parent_comment_id' => null,
//                     'parent_id' => $this->parent->id,
//                     'progress_status' => 'progressing',
//                 ]);
//                  Notification::make()
//                     ->title('Session berhasil dibuat')
//                     ->body('Catatan mentoring baru telah ditambahkan.')
//                     ->success()
//                     ->send();

//                      $this->loadSessions();

//             }),

//     ];
// }
    public function loadSessions(): array
    {
        $sessionId = $this->studentTopic->mentoringSessions?->id;
       
        if (!$sessionId) {
            return $this->sessions = [];
        }

        $this->lastSession = MentoringComment::query()
            ->where('mentoring_session_id', $sessionId)
            ->whereNull('parent_comment_id')
            ->latest()
            ->first();

        return $this->sessions = MentoringComment::query()
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
                    'mentor' => $mentorName,
                    'parent_id' => $item->parent_id,
                    'teacher_id' => $item->teacher_id,
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
                                                    ->label('Last Session')
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
                                                    ->label('Start Date'),

                                                TextEntry::make('mentoringSessions.end_date')
                                                    ->date()
                                                    ->hidden(fn() => $this->studentTopic?->status === 'in_progress')
                                                    ->label('End Date')
                                            ])->columns(2),

                                        Section::make('Learning Topic')
                                            ->description('Information about the student\'s learning topic, including description, achievement targets, teaching strategies, and learning resources.')
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
                                                Section::make('Learning Resources')
                                                    ->icon('heroicon-o-paper-clip')
                                                    ->compact()
                                                    ->schema([
                                                        TextEntry::make('topic.url')
                                                            ->label('File / Materi')
                                                            ->url(fn($state) => $state)
                                                            ->openUrlInNewTab()
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
                                            ->hidden(fn() => $this->studentTopic?->status === 'completed')
                                            ->statePath('session_details')
                                            ->schema([
                                                TextEntry::make('topic.title')
                                                    ->label('Topic Title')
                                                    ->color('primary')
                                                    ->inlineLabel()
                                                    ->columnSpanFull(),
                                                RichEditor::make('message')
                                                    ->label('Mentoring Notes')
                                                    ->toolbarButtons([
                                                        ['bold', 'italic', 'underline', 'strike', 'subscript', 'superscript', 'link'],
                                                        ['h2', 'h3'],
                                                        ['blockquote', 'bulletList', 'orderedList'],
                                                    ])
                                                    ->placeholder('Type your mentoring notes here...')
                                                    ->extraAttributes([
                                                        'style' => 'min-height:300px',
                                                    ]),
                                                // Select::make('progress_status')
                                                //     ->label('Progress Belajar')
                                                //     ->required()

                                                //     ->default('developing')
                                                //     ->options([
                                                //         'pending_support' => 'Perlu Pendampingan',
                                                //         'developing' => 'Sedang Berkembang',
                                                //         'reinforcement' => 'Perlu Penguatan',
                                                //         'progressing' => 'Menunjukkan Perkembangan',
                                                //         'good' => 'Memahami dengan Baik',
                                                //         'excellent' => 'Sangat Baik',
                                                //     ])

                                                //     ->columnSpanFull(),
                                                TextInput::make('mentoring_session_id')
                                                    ->hidden(),

                                                Action::make('saveSession')
                                                    ->label('Save Notes')
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
                                                             'parent_id' => $this->parent->id,
                                                            'progress_status' => $this->session_details['progress_status'] ?? null,
                                                        ];

                                                        $editId = $this->session_details['mentoring_session_id'] ?? null;

                                                        if ($editId) {
                                                            $createComment = MentoringComment::find($editId)?->update([
                                                                'message' => $html,
                                                                'progress_status' => $this->session_details['progress_status'] ?? null,
                                                            ]);
                                                        } else {
                                                            $createComment = MentoringComment::create($dataCreate);
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
                                                View::make('filament.parent.pages.timeline-mentoring')

                                            ])->columns(1),
                                    ])
                            ]),

                    ])->contained(false)
            ]);
    }

    public function editSession($id)
    {

        $getComment = MentoringComment::find($id);

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
            ->hidden(fn() => $this->studentTopic?->mentoringSessions->comments->parent_id === null)
            ->modalHeading('Delete Comment')
            ->modalDescription('Are you sure you want to delete this comment? This action cannot be undone.')
            ->modalSubmitActionLabel('Yes, Delete')
            ->color('danger')
            ->action(function (array $arguments) {
                $test = $this->studentTopic?->mentoring_sessions->comments->parent_id === null;
                
                
               
                    Notification::make()
                        ->title('ID catatan tidak ditemukan')
                        ->danger()
                        ->send();
                    return;
                
                MentoringComment::find($arguments['id'])?->delete();

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
                    ->label('Response')
                    ->placeholder('Type your response here...')
                    ->rows(4)
                    ->hidden(fn() => $this->studentTopic?->status === 'completed')
                    ->required()
                    ->maxLength(1000),
            ]);
    }

    public function sendReply($id)
    {

        $parent = MentoringComment::findOrFail($id);

        MentoringComment::create([
            'mentoring_session_id' => $parent->mentoring_session_id,
            'parent_comment_id' => $id,
            'parent_id' => $this->parent->id,
            'message' => $this->data['message'],
        ]);



        $this->loadSessions();
        $this->form->fill(); // reset aman
    }
}
