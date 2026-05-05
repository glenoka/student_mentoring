<?php

namespace App\Filament\Pages;

use App\Filament\Exports\MonitoringSessionExporter;
use App\Models\mentoring_session;
use App\Models\MentoringSession;
use BackedEnum;
use Barryvdh\DomPDF\Facade\Pdf;
use BezhanSalleh\FilamentShield\Traits\HasPageShield;
use Filament\Actions\Action;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Actions\ExportAction;
use Filament\Pages\Page;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use UnitEnum;

class HistorySession extends Page implements HasActions, HasSchemas, HasTable
{
    use InteractsWithActions;
    use InteractsWithSchemas;
    use InteractsWithTable;
    use HasPageShield;

    public $dataQuery;
    protected string $view = 'filament.pages.history-session';
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBookmarkSquare;
    protected static ?string $navigationLabel = 'Riwayat Mentoring';
    protected static string | UnitEnum | null $navigationGroup = 'Assessments & Mentoring';

    

    public function table(Table $table): Table
    {
        return $table
            ->query(function () {
                $user = auth()->user();

                $query = MentoringSession::query()
                    ->with('studentTopic.student', 'studentTopic.topic', 'user.teacher');

                if ($user->hasRole('User')) {
                    $query->where('user_id', $user->id);
                }

                return $query;
            })
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
                TextColumn::make('studentTopic.status')
                    ->label('Status')
                    ->badge()
                    ->color(fn($state) => match ($state) {
                        'not_started' => 'danger',
                        'in_progress' => 'warning',
                        'completed' => 'success'
                    })
                    ->formatStateUsing(
                        fn($state) => match ($state) {
                            'not_started' => 'Belum Mulai',
                            'in_progress' => 'Sedang Berjalan',
                            'completed' => 'Selesai'
                        }
                    ),

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
                Action::make('export_pdf')
                    ->label('Export PDF')
                    ->icon('heroicon-o-document-arrow-down')
                    ->color('danger')
                    ->action(function ($livewire) {

                        // 🔥 ambil data sesuai filter table
                        $data = $livewire->getFilteredTableQuery()->get();

                        $pdf = Pdf::loadView('pdf.sessions', [
                            'sessions' => $data
                        ])->setPaper('a4', 'landscape');

                        return response()->streamDownload(
                            fn() => print($pdf->output()),
                            'laporan-sesi.pdf'
                        );
                    }),
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
