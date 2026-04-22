<?php

namespace App\Filament\Resources\Teachers\Pages;

use App\Filament\Resources\Teachers\TeachersResource;
use App\Models\User;
use Filament\Resources\Pages\CreateRecord;

class CreateTeachers extends CreateRecord
{
    protected static string $resource = TeachersResource::class;
    protected function mutateFormDataBeforeCreate(array $data): array
{
    $dataUser = [
        'name' => $data['name'],
        'email' => $data['username'].'@example.com',
        'username' => $data['username'],
        'password' => bcrypt($data['password']),
    ];
    $user= User::updateOrCreate(['username' => $data['username']], $dataUser);
    $data['user_id'] = $user->id;

    return [
        'name' => $data['name'],
        'user_id' => $data['user_id'],
    ];

    
}
}
