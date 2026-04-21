<?php

namespace App\Filament\Resources\Parents;

use App\Filament\Resources\Parents\Pages\CreateParents;
use App\Filament\Resources\Parents\Pages\EditParents;
use App\Filament\Resources\Parents\Pages\ListParents;
use App\Filament\Resources\Parents\Schemas\ParentsForm;
use App\Filament\Resources\Parents\Tables\ParentsTable;
use App\Models\Parents;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ParentsResource extends Resource
{
    protected static ?string $model = Parents::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return ParentsForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ParentsTable::configure($table);
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
            'index' => ListParents::route('/'),
            'create' => CreateParents::route('/create'),
            'edit' => EditParents::route('/{record}/edit'),
        ];
    }
}
