<?php

namespace App\Filament\Resources\Assessments\Pages;

use App\Filament\Resources\Assessments\AssessmentsResource;
use App\Models\assessment_answers;
use App\Models\questions;
use Filament\Actions\Action;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\ToggleButtons;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\Page;
use Filament\Schemas\Components\Actions;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;

class DoAssessment extends Page implements HasForms
{
    use InteractsWithForms;
    protected static string $resource = AssessmentsResource::class;

    protected string $view = 'filament.resources.assessments.pages.do-assessment';
    public $record;
    public ?array $data = [];
    public function mount($record): void
    {

        $this->record = $record;
    }
    protected function getCreateFormAction(): array
    {

        return [
            Action::make('back')
                ->label('test')
                ->button()
                ->icon('heroicon-o-arrow-left')
                ->url(AssessmentsResource::getUrl('index'))

                ->color('secondary'),
        ];
    }
    public function assessmentSchema(Schema $schema): Schema
    {
        $numericQuestions = questions::where('type', 'numeric')->get();
        $booleanQuestions = questions::where('type', 'boolean')->get();

        $numericQuestionsMapped = $numericQuestions->values()->map(function ($question, $index) {
            return Section::make(($index + 1) . '. ' . $question->question_text)
                ->schema([
                    Grid::make([
                        'md' => 4,
                    ])->schema([
                        TextInput::make("answers_numeric.{$question->id}")
                            ->numeric()
                            ->required()
                            ->hiddenLabel()
                            ->minValue(1)
                            ->maxValue(100)
                            ->placeholder('Masukkan nilai 1 - 100')
                            ->suffix('%')
                            ->required()
                            ->columnSpan(1),
                    ]),
                ])
                ->columns(1)
                ->extraAttributes([
                    'class' => 'mb-3 border-l-4 border-primary-500'
                ]);
        })->toArray();

        $booleanQuestionsMapped = $booleanQuestions->values()->map(function ($question, $index) {
            return Section::make(($index + 1) . '. ' . $question->question_text)
                ->schema([
                    Grid::make([
                        'md' => 4,
                    ])->schema([
                        Radio::make("answers_boolean.{$question->id}")
                            ->hiddenLabel()
                            ->required()
                            ->options([
                                1 => 'Ya',
                                0 => 'Tidak',
                            ])
                            ->inline()
                            ->required()
                            ->live()
                            ->columnSpan(1),
                        TextInput::make("answers_boolean_notes.{$question->id}")
                            ->hiddenLabel()
                            ->placeholder('Catatan (opsional)')
                            ->columnSpanFull()
                            ->visible(fn (Get $get) => $get("answers_boolean.{$question->id}") == 1),
                    ]),
                ])
                ->columns(1)
                ->extraAttributes([
                    'class' => 'mb-3 border-l-4 border-success-500'
                ]);
        })->toArray();

        return $schema->components([
            Section::make('📊 Penilaian Angka')
                ->description('Berikan nilai dari 1 sampai 100')
                ->collapsible()
                ->schema($numericQuestionsMapped),

            Section::make('✅ Pertanyaan Ya / Tidak')
                ->description('Pilih jawaban yang sesuai')
                ->collapsible()
                ->schema($booleanQuestionsMapped),

            Actions::make([
                Action::make('simpan')
                    ->label('Submit Assessment')
                    ->icon('heroicon-o-check')
                    ->color('primary')
                    ->requiresConfirmation()
                    ->modalHeading('Konfirmasi Submit')
                    ->modalDescription('Apakah Anda yakin ingin menyimpan semua jawaban?')
                    ->modalSubmitActionLabel('Ya, Simpan')
                    ->action(function () {
                        $data = $this->data;
                        // Simpan jawaban boolean
                        foreach ($data['answers_boolean'] as $questionId => $value) {
                            assessment_answers::create([
                                'assessment_id' => $this->record,
                                'question_id'   => $questionId,
                                'boolean_value' => (bool) $value,
                                'notes'         => $data['answers_boolean_notes'][$questionId] ?? null,
                                'numeric_value' => null,
                            ]);
                        }

                        // Simpan jawaban numeric
                        foreach ($data['answers_numeric'] as $questionId => $value) {
                            assessment_answers::create([
                                'assessment_id' => $this->record,
                                'question_id'   => $questionId,
                                'numeric_value' => $value,
                                'boolean_value' => null,
                            ]);
                        }

                        Notification::make()
                            ->title('Berhasil disimpan!')
                            ->success()
                            ->send();
                    }),
            ]),
        ])->statePath('data');
    }
}
