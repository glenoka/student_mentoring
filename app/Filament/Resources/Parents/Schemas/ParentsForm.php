<?php

namespace App\Filament\Resources\Parents\Schemas;

use App\Models\User;
use Closure;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class ParentsForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Name')
                    ->columnSpanFull()
                    ->required(),
                TextInput::make('username')
                    ->label('Username')
                    
                    ->formatStateUsing(function ($record) {
                       return $record?->user?->username;
                    })
                    ->readOnly(fn (string $context): bool => $context === 'edit')
                   ->rules([
        function ($record) {
            return function (string $attribute, $value, Closure $fail) use ($record) {

                $exists = User::where('username', $value)
                    ->when($record?->user_id, function ($query) use ($record) {
                        $query->where('id', '!=', $record->user_id);
                    })
                    ->exists();

                if ($exists) {
                    $fail('Username sudah digunakan.');
                }
            };
        },
    ])
                    ->required(),
                    
                TextInput::make('password')
                    ->label('Password')
                    ->password()
                    ->required(fn (string $context): bool => $context === 'create'),
            ]);
    }
}
