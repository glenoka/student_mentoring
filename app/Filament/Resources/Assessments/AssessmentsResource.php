<?php

namespace App\Filament\Resources\Assessments;

use App\Filament\Resources\Assessments\Pages\CreateAssessments;
use App\Filament\Resources\Assessments\Pages\EditAssessments;
use App\Filament\Resources\Assessments\Pages\ListAssessments;
use App\Filament\Resources\Assessments\Schemas\AssessmentsForm;
use App\Filament\Resources\Assessments\Tables\AssessmentsTable;
use App\Models\Assessments;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class AssessmentsResource extends Resource
{
    protected static ?string $model = Assessments::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'a';

    public static function form(Schema $schema): Schema
    {
        return AssessmentsForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return AssessmentsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListAssessments::route('/'),
            'create' => CreateAssessments::route('/create'),
            'edit' => EditAssessments::route('/{record}/edit'),
        ];
    }
}
