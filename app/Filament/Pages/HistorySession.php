<?php

namespace App\Filament\Pages;

use App\Filament\Exports\MonitoringSessionExporter;
use App\Models\mentoring_session;
use BezhanSalleh\FilamentShield\Traits\HasPageShield;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Actions\ExportAction;
use Filament\Pages\Page;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class HistorySession extends Page implements HasActions, HasSchemas, HasTable
{
    use InteractsWithActions;
    use InteractsWithSchemas;
    use InteractsWithTable;
    use HasPageShield;
    protected string $view = 'filament.pages.history-session';

    public function table(Table $table): Table
    {
        return $table
            ->query(mentoring_session::with('studentTopic.student', 'studentTopic.topic', 'user.teacher'))
            ->columns([
                TextColumn::make('session_date')
                    ->label('Tanggal')
                    ->date('d M Y')
                    ->sortable(),

                TextColumn::make('studentTopic.student.name')
                    ->label('Siswa')
                    ->searchable()
                    ->weight('medium'),

                TextColumn::make('studentTopic.topic.title')
                    ->label('Topik')
                    ->badge()
                    ->color('success')
                    ->icon('heroicon-o-book-open')
                    ->limit(20),

                TextColumn::make('user.teacher.name')
                    ->label('Guru')
                    ->color('warning')
                    ->searchable(),
            ])
            ->headerActions([
                ExportAction::make()
                    ->label('Export XLS')
                    ->color('success')
                    ->exporter(MonitoringSessionExporter::class),
            ])
            ->filters([
                SelectFilter::make('month')
                    ->label('Bulan')

                    ->options([
                        '01' => 'Januari',
                        '02' => 'Februari',
                        '03' => 'Maret',
                        '04' => 'April',
                        '05' => 'Mei',
                        '06' => 'Juni',
                        '07' => 'Juli',
                        '08' => 'Agustus',
                        '09' => 'September',
                        '10' => 'Oktober',
                        '11' => 'November',
                        '12' => 'Desember',
                    ])
                    ->query(function (Builder $query, array $data) {
                        if ($data['value']) {
                            $query->whereMonth('session_date', $data['value']);
                        }
                    }),

                SelectFilter::make('teacher')
                    ->label('Guru')
                    ->relationship('user.teacher', 'name')
                    ->searchable()
                    ->preload(),

            ]);
    }
}
