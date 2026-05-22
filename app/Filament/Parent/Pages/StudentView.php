<?php

namespace App\Filament\Parent\Pages;

use App\Models\Assessments;
use App\Models\Parents;
use App\Models\Student;
use BackedEnum;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Pages\Page;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\View;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Facades\Auth;


class StudentView extends Page implements HasSchemas
{
    use InteractsWithSchemas;

    protected string $view = 'filament.parent.pages.student-view';
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUserCircle;
    protected static ?string $navigationLabel = 'Student Detail';
    protected static ?string $title = 'Student Detail';

    public array $data = [];
    public $student;
     public $record;
     public $booleanAnswers;
     public $numericAnswers;
    public function mount()
    {
        $parentID = Parents::where('user_id', Auth::user()->id)->first();
    
        $this->student = Student::where('parent_id', $parentID->id)
            ->with('assessments.answers.question', 'studentTopics.topic', 'studentTopics.mentoringSessions.comments')
            ->first();
     if (!$this->student) {

    abort(response()->view('errors.errorhandling', [
            'code' => 404,
            'title' => 'Student Not Found',
            'message' => 'No student associated with the current parent was found. Please contact administrator for assistance.',
        ], 404));
}
        

      
 $this->record = Assessments::with(['student', 'answers.question'])->where('student_id', $this->student->id)->firstOrFail();
// dd($this->record);

        // Fill data as array for the schema
        $this->data = $this->student?->toArray() ?? [];

          $answers = $this->record->answers->load('question');

        $this->numericAnswers = $answers->filter(fn($a) => $a->question->type === 'numeric');
      
        $this->booleanAnswers = $answers->filter(fn($a) => $a->question->type === 'boolean' && $a->boolean_value == 1);

    }

    public function studentDetail(Schema $schema): Schema
    {
      

        return $schema
            ->record($this->student)
            ->components([
                Section::make('Student Information')
                    ->description('Student details, including name, class, and assessment status.')
                    ->icon('heroicon-o-academic-cap')
                    ->schema([
                        TextEntry::make('name')
                            ->label('Student Name')
                            ->weight('bold'),

                        TextEntry::make('class')
                            ->label('Class')
                            ->badge()
                            ->color('primary'),

                        TextEntry::make('assessments.status')
                            ->label('Assessment Status')
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
                            ->label('Assessment Date')
                            ->date('d M Y'),
                    ])
                    ->columns(2)
                    ->collapsible(),
                Section::make('Assessment Results')
                    
                    ->description('Topics identified from the latest assessment and their details')
                  
                ->label('Assessment Results')
                    ->icon('heroicon-o-bookmark')
                   
                    ->schema( [ 
                        View::make('filament.parent.pages.assessments-result')
            ->viewData([
                'booleanAnswers' => $this->booleanAnswers,
                'numericAnswers' => $this->numericAnswers,
            ]),
                        
                        ]),
                Section::make('Topic')
                    ->icon('heroicon-o-bookmark')
                    ->description('Topics identified from the latest assessment and their details')
                    ->schema([
                        RepeatableEntry::make('studentTopics')
                            ->label('Learning Progress')
                            ->contained(false)
                            ->schema([

                                Section::make(fn($record) => $record->topic?->title ?? 'Topik')
                                    ->description('Detail of the learning topic, including status, session dates, and number of sessions.')
                                    ->icon('heroicon-o-document')
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
                                            ->label('First Session Date')
                                            ->date('d M Y')
                                            ->visible(fn($state) => filled($state))
                                            ->icon('heroicon-o-calendar-days'),

                                        TextEntry::make('comments_count')
                                            ->label('Session Count')
                                            ->state(function ($record) {

                                                return $record->mentoringSessions?->comments

                                                    ->whereNull('parent_comment_id')
                                                    ->count();
                                            })
                                            ->badge()
                                            ->color('info')
                                            ->formatStateUsing(fn($state) => $state . ' Sesi'),
                                        TextEntry::make('last_session')
                                            ->label('Last Session')
                                            ->state(function ($record) {

                                                $latestComment = $record->mentoringSessions?->comments
                                                    ->whereNull('parent_comment_id')
                                                    ->sortByDesc('created_at')
                                                    ->first();

                                                return $latestComment?->created_at;
                                            })
                                            ->date('d M Y')
                                            ->visible(fn($state) => filled($state))
                                            ->icon('heroicon-o-calendar-days'),

                                    ])
                                    ->columns(2)
                                    ->collapsible(),

                            ]),
                    ])
            ]);
    }
}
