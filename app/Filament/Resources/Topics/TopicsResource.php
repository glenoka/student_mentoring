<?php

namespace App\Filament\Resources\Topics;

use App\Filament\Resources\Topics\Pages\CreateTopics;
use App\Filament\Resources\Topics\Pages\EditTopics;
use App\Filament\Resources\Topics\Pages\ListTopics;
use App\Filament\Resources\Topics\Schemas\TopicsForm;
use App\Filament\Resources\Topics\Tables\TopicsTable;
use App\Models\Topics;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class TopicsResource extends Resource
{
    protected static ?string $model = Topics::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Schema $schema): Schema
    {
        return TopicsForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return TopicsTable::configure($table);
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
            'index' => ListTopics::route('/'),
            'create' => CreateTopics::route('/create'),
            'edit' => EditTopics::route('/{record}/edit'),
        ];
    }
}
