<?php

namespace App\Filament\Resources\StudentTopics;

use App\Filament\Resources\StudentTopics\Pages\CreateStudentTopics;
use App\Filament\Resources\StudentTopics\Pages\EditStudentTopics;
use App\Filament\Resources\StudentTopics\Pages\ListStudentTopics;
use App\Filament\Resources\StudentTopics\Schemas\StudentTopicsForm;
use App\Filament\Resources\StudentTopics\Tables\StudentTopicsTable;
use App\Models\student_topics;
use App\Models\StudentTopic;
use App\Models\StudentTopics;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class StudentTopicsResource extends Resource
{
    protected static ?string $model = StudentTopic::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCheckBadge;
    protected static ?string $navigationLabel = 'Mentoring';
    protected static string | UnitEnum | null $navigationGroup = 'Assessments & Mentoring';
    protected static ?string $slug = 'sesimentoring';
protected static ?string $pluralModelLabel = 'Sesi Mentoring';
    

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
