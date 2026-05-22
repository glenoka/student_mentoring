<?php

namespace App\Filament\Parent\Pages;

use App\Filament\Parent\Pages\MentoringSessionComments;
use App\Models\MentoringSession as ModelMentoringSession;
use App\Models\Parents;
use App\Models\Student;
use App\Models\StudentTopic;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Pages\Page;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;

class MentoringSession extends Page implements HasActions, HasSchemas, HasTable
{
    use InteractsWithActions;
    use InteractsWithSchemas;
    use InteractsWithTable;

    protected static ?string $pluralModelLabel = 'Parent Mentoring';
    protected static ?string $navigationLabel = 'Parent Mentoring';
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCheckBadge;

    protected string $view = 'filament.parent.pages.mentoring-session';
    public $student;
    public function mount()
    {

        $parentID = Parents::where('user_id', Auth::user()->id)->first();
        if ($parentID->student == null) {
            abort(response()->view('errors.errorhandling', [
                'code' => 404,
                'title' => 'Student Not Found',
                'message' => 'No student associated with the current parent was found. Please contact administrator for assistance.',
            ], 404));
        }
        $student = Student::query();
        $this->student = $student->with([
            'assessments.answers.question',
            'studentTopics.topic',
            'studentTopics.mentoringSessions.comments',
        ])
            ->where('parent_id', $parentID->id)
            ->firstOrFail();
    }
    protected function getTables(): array
    {
        return [
            'dataTopicTable',
        ];
    }
    public function table(Table $table): Table
    {
        return $table
            ->query(
                StudentTopic::query()
                    ->with('topic', 'mentoringSessions.latestComment')
                    ->where('student_id', $this->student->id)
            )
            ->columns([
                TextColumn::make('topic.title')
                    ->label('Topic'),
                TextColumn::make('mentoringSessions.session_date')
                    ->date('d-m-Y')
                    ->label('Tanggal Mulai'),
                TextColumn::make('mentoringSessions.status')
                    ->label('Status')
                    ->badge()
                    ->color(fn(?string $state): string => match ($state) {
                        'done' => 'success',
                        'in_progress' => 'warning',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn(?string $state): string => match ($state) {
                        'done' => 'Finished',
                        'in_progress' => 'On Progress',
                    }),
                TextColumn::make('mentoringSessions.latestComment.message')
                    ->html(),

            ])
            ->filters([

                // ...
            ])
            ->recordActions([
                Action::make('Lanjut')
                    ->label(
                        fn(StudentTopic $record) =>
                        $record->mentoringSessions()->exists()
                            ? 'Continue Session'
                            : 'New Session'
                    )
                    ->url(fn(StudentTopic $record) => MentoringSessionComments::getUrl([
                        'uuid' => $record->uuid,
                    ]))
                    ->icon(
                        fn(StudentTopic $record) =>
                        $record->mentoringSessions()->exists()
                            ? 'heroicon-o-arrow-right'
                            : 'heroicon-o-plus'
                    )

                    ->color(
                        fn(StudentTopic $record) =>
                        $record->mentoringSessions()->exists()
                            ? 'primary'
                            : 'success'
                    ),
            ])
            ->toolbarActions([
                // ...
            ]);
    }
}
