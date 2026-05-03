<?php

namespace App\Filament\Resources\Teachers\Pages;

use App\Filament\Resources\Teachers\TeachersResource;
use App\Models\User;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditTeachers extends EditRecord
{
    protected static string $resource = TeachersResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
protected function mutateFormDataBeforeSave(array $data): array
{
dd($data);
    $dataUser = [
        'name' => $data['name'],
        'email' => $data['username'].'@example.com',
        'username' => $data['username'],
        'password' => bcrypt($data['password']),
    ];
    $user= User::updateOrCreate(['username' => $data['username']], $dataUser);
    $data['user_id'] = $user->id;

   $user->assignRole($data['roles']);

    return [
        'name' => $data['name'],
        'user_id' => $data['user_id'],
    ];
}
}
