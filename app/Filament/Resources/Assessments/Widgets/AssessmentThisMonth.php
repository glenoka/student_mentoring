<?php

namespace App\Filament\Resources\Assessments\Widgets;


use App\Models\Assessments as ModelsAssessments;
use Carbon\Carbon;
use Filament\Actions\BulkActionGroup;
use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;
use PhpParser\Node\Stmt\Label;

class AssessmentThisMonth extends TableWidget
{
    public function table(Table $table): Table
    {
        return $table
            ->query(fn (): Builder => ModelsAssessments::query()
             ->whereMonth('created_at', now()->month)
    ->whereYear('created_at', now()->year))
            ->columns([
                TextColumn::make('student.name')
                ->label('Nama Siswa'),
                TextColumn::make('created_at')
                ->label('Tanggal')
                ->date('Y-m-d'),
                TextColumn::make('status')
                ->label('Status')
                ->formatStateUsing(fn($state)=>match ($state){
                    'finished' => 'Selesai',
                    'not_started' => 'Belum Mulai'
                })
            ])
            ->filters([
                //
            ])
            ->headerActions([
                //
            ])
            ->recordActions([
                //
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    //
                ]),
            ]);
    }
}
