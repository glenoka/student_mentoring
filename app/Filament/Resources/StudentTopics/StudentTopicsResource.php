<?php

namespace App\Filament\Resources\StudentTopics;

use App\Filament\Resources\StudentTopics\Pages\CreateStudentTopics;
use App\Filament\Resources\StudentTopics\Pages\EditStudentTopics;
use App\Filament\Resources\StudentTopics\Pages\ListStudentTopics;
use App\Filament\Resources\StudentTopics\Schemas\StudentTopicsForm;
use App\Filament\Resources\StudentTopics\Tables\StudentTopicsTable;
use App\Models\student_topics;
use App\Models\StudentTopics;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class StudentTopicsResource extends Resource
{
    protected static ?string $model = student_topics::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'student.name';

    public static function form(Schema $schema): Schema
    {
        return StudentTopicsForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return StudentTopicsTable::configure($table);
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
            'index' => ListStudentTopics::route('/'),
            //'create' => CreateStudentTopics::route('/create'),
            //'edit' => EditStudentTopics::route('/{record}/edit'),
            'mentoring-session' => Pages\MentoringSession::route('/{record}/mentoring-session'),
        ];
    }
}
