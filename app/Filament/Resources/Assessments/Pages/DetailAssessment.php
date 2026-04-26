<?php

namespace App\Filament\Resources\Assessments\Pages;

use App\Filament\Resources\Assessments\AssessmentsResource;
use App\Models\assessments;
use App\Models\student_topics;
use App\Models\topics;
use Filament\Actions\Action;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Infolists\Components\TextEntry;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\Page;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Model;


class DetailAssessment extends Page
{
    protected static string $resource = AssessmentsResource::class;

    protected string $view = 'filament.resources.assessments.pages.detail-assessment';

    public $record;

    public ?array $topics = [];
    public $data = [];
    public $studentTopicId;
    public function mount($record): void
    {

        $this->record = assessments::with(['student', 'answers.question'])->where('uuid', $record)->firstOrFail();

        $this->data['topics'] = student_topics::where('assessment_id', $this->record->id)
            ->get()
            ->map(fn($item) => [
                'id'       => $item->id,
                'topic_id' => $item->topic_id,
            ])
            ->toArray();
    }


    public function detailAssessmentInfolist(Schema $schema): Schema
    {
        $answers = $this->record->answers->load('question');

        $numericAnswers = $answers->filter(fn($a) => $a->question->type === 'numeric');
        $booleanAnswers = $answers->filter(fn($a) => $a->question->type === 'boolean');

        return $schema
            ->record($this->record)
            ->components([

                // ─── HEADER SUMMARY ───────────────────────────────────────────────
                Section::make()
                    ->components([
                        Grid::make(3)
                            ->components([
                                TextEntry::make('assessment_date')
                                    ->label('Tanggal Penilaian')
                                    ->icon('heroicon-o-calendar-days')
                                    ->date('d M Y'),

                                TextEntry::make('student.name')
                                    ->label('Nama Siswa')
                                    ->icon('heroicon-o-user-circle')
                                    ->default('—'),

                                TextEntry::make('status')
                                    ->label('Status')
                                    ->badge()
                                    ->color(fn(string $state): string => match ($state) {
                                        'not_started' => 'gray',
                                        'finished'   => 'success',
                                        default     => 'info',
                                    })
                                    ->formatStateUsing(fn(?string $state): string => match ($state) {
                                        'not_started' => 'Not Started',
                                        'finished'   => 'Finished',
                                        default     => 'Dalam Proses',
                                    }),
                            ]),
                    ])
                    ->columnSpanFull(),

                // ─── TABS: Numeric + Boolean ───────────────────────────────────────
                Tabs::make('Assessment')
                    ->tabs([

                        // 📊 NUMERIC TAB
                        Tab::make('Penilaian Angka')
                            ->icon('heroicon-o-calculator')
                            ->components(
                                $numericAnswers->isNotEmpty()
                                    ? [
                                        Grid::make(2)->components(
                                            $numericAnswers
                                                ->map(
                                                    fn($answer) =>
                                                    TextEntry::make('answer_' . $answer->id)
                                                        ->label($answer->question->question_text)
                                                        ->state(((int) $answer->numeric_value) . ' %')
                                                        ->badge()
                                                        ->color('info')
                                                )
                                                ->values()
                                                ->all()
                                        ),
                                    ]
                                    : [
                                        TextEntry::make('no_numeric')
                                            ->label('')
                                            ->state('Tidak ada pertanyaan numerik.')
                                            ->icon('heroicon-o-information-circle')
                                            ->color('gray'),
                                    ]
                            ),

                        // ✅ BOOLEAN TAB
                        Tab::make('Ya / Tidak')
                            ->label('Pertanyaan Ya / Tidak')
                            ->icon('heroicon-o-check-badge')
                            ->components(
                                $booleanAnswers->isNotEmpty()
                                    ? $booleanAnswers
                                    ->map(function ($answer, $index) {

                                        $schema = [
                                            TextEntry::make('answer_bool_' . $answer->id)
                                                ->label('Pertanyaan ' . ($index + 1))
                                                ->html()
                                                ->state(function () use ($answer) {
                                                    $icon = $answer->boolean_value
                                                        ? '✅'
                                                        : '❌';

                                                    return "{$icon} {$answer->question->question_text}";
                                                })
                                        ];

                                        if ($answer->boolean_value && $answer->notes) {
                                            $schema[] = TextEntry::make('answer_note_' . $answer->id)
                                                ->hiddenLabel()
                                                ->icon('heroicon-o-chat-bubble-left')
                                                ->state($answer->notes)
                                                ->columnSpanFull();
                                        }

                                        return Section::make()
                                            ->schema($schema)
                                            ->columns(1)
                                            ->collapsible(false);
                                    })
                                    ->values()
                                    ->all()
                                    : [
                                        TextEntry::make('empty')
                                            ->label('')
                                            ->state('Tidak ada pertanyaan ya/tidak.')
                                    ]
                            ),
                        Tab::make('Topik')
                            ->label('Topik yang Dipelajari')
                            ->icon('heroicon-o-square-3-stack-3d')
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
                                                $this->studentTopicId = $get('id');
                                                student_topics::updateOrCreate(
                                                    [
                                                        'id' => $this->studentTopicId,
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
                            ])->statePath('data'),

                    ])
                    ->columnSpanFull(),
            ]);
    }


    protected function getHeaderActions(): array
    {
        return [
            Action::make('back')
                ->label('Kembali')
                ->icon('heroicon-o-arrow-left')
                ->url(route('filament.admin.resources.assessments.index'))
                ->color('gray'),
        ];
    }
}
