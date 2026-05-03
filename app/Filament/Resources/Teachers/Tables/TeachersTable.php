<?php

namespace App\Filament\Resources\Teachers\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class TeachersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                TextColumn::make('name')->label('Name'),
                TextColumn::make('user.username')->label('Username'),
                TextColumn::make('user.roles.name')
                    ->label('Role')
                    ->badge()
                    ->getStateUsing(
                        fn($record) =>
                        $record->user?->roles?->pluck('name')->implode(', ') ?? '-'
                    ),
            ])
            ->filters([
                //
            ])


            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make()
                    ->after(function ($record, array $data) {

                        // ambil user dari teacher
                        $user = $record->user;

                        if ($user) {
                            // kalau single role
                            $user->syncRoles($data['roles'] ?? []);

                            // atau kalau mau assign saja (tanpa hapus lama)
                            // $user->assignRole($data['roles']);
                        }
                    }),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
