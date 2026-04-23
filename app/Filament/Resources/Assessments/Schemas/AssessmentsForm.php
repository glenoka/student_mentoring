<?php

namespace App\Filament\Resources\Assessments\Schemas;


use App\Models\students;
use Carbon\Carbon;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Schemas\Schema;

class AssessmentsForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('student_id')
                    ->label('Student')
                    ->options(students::all()->pluck('name', 'id'))
                    ->required(),
                DatePicker::make('assessment_date')
                    ->label('Assessment Date')
                    ->default(Carbon::today())
                    ->required(),
            ]);
    }
}
