<?php

namespace App\Filament\Exports;

use App\Models\mentoring_session;
use App\Models\MonitoringSession;
use Carbon\Carbon;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;
use Illuminate\Support\Number;
use OpenSpout\Writer\XLSX\Options;

class MonitoringSessionExporter extends Exporter
{
    protected static ?string $model = mentoring_session::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('session_date')
    ->label('Tanggal')
    ->formatStateUsing(fn ($state) => 
        $state ? Carbon::parse($state)->translatedFormat('d M Y') : '-'
    ),

ExportColumn::make('studentTopic.student.name')
    ->label('Nama Siswa')
    ->formatStateUsing(fn ($state) => $state ?? '-'),

ExportColumn::make('studentTopic.topic.title')
    ->label('Judul Topik')
    ->formatStateUsing(fn ($state) => 
        $state ? strtoupper($state) : '-'
    ),

ExportColumn::make('user.teacher.name')
    ->label('Guru')
    ->formatStateUsing(fn ($state) => $state ?? '-'),
            
        ];
    }
 
public function columnWidths(): array
    {
        return [
            'A' => 20, // Tanggal
            'B' => 30, // Siswa
            'C' => 40, // Topik
            'D' => 30, // Guru
        ];
    }
    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your monitoring session export has completed and ' . Number::format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . Number::format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}
