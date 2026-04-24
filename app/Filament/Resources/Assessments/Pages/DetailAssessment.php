<?php

namespace App\Filament\Resources\Assessments\Pages;

use App\Filament\Resources\Assessments\AssessmentsResource;
use App\Models\assessments;
use Filament\Actions\Action;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Pages\Page;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;


class DetailAssessment extends Page
{
    protected static string $resource = AssessmentsResource::class;

    protected string $view = 'filament.resources.assessments.pages.detail-assessment';
    
    public $record;
     public function mount($record): void
    {

        $this->record = assessments::with(['student', 'answers.question'])->where('uuid', $record)->firstOrFail();
       
    }


public function detailAssessmentInfolist(Schema $schema): Schema
{
    $answers = $this->record->answers->load('question');

    $numericAnswers = $answers->filter(fn ($a) => $a->question->type === 'numeric');
    $booleanAnswers = $answers->filter(fn ($a) => $a->question->type === 'boolean');

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

                            TextEntry::make('assessor.name')
                                ->label('Penilai')
                                ->icon('heroicon-o-user-circle')
                                ->default('—'),

                            TextEntry::make('status')
                                ->label('Status')
                                ->badge()
                                ->color(fn (string $state): string => match ($state) {
                                    'not_started' => 'gray',
                                    'finished'   => 'success',
                                    default     => 'info',
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
                                            ->map(fn ($answer) =>
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
                        ->icon('heroicon-o-check-badge')
                        ->components(
                            $booleanAnswers->isNotEmpty()
                                ? $booleanAnswers
                                    ->flatMap(function ($answer) {
                                        $entries = [
                                            IconEntry::make('answer_bool_' . $answer->id)
                                                ->label($answer->question->question_text)
                                                ->boolean()
                                                ->inlineLabel(true)
                                                ->state($answer->boolean_value),
                                        ];

                                        if ($answer->boolean_value && $answer->notes) {
                                            $entries[] = TextEntry::make('answer_note_' . $answer->id)
                                                ->label('Catatan')
                                                ->state($answer->notes)
                                                ->icon('heroicon-o-chat-bubble-left-ellipsis')
                                                ->color('gray')
                                                ->columnSpanFull();
                                        }

                                        return $entries;
                                    })
                                    ->values()
                                    ->all()
                                : [
                                    TextEntry::make('no_boolean')
                                        ->label('')
                                        ->state('Tidak ada pertanyaan ya/tidak.')
                                        ->icon('heroicon-o-information-circle')
                                        ->color('gray'),
                                  ]
                        ),
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
