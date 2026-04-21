<?php

namespace App\Filament\Resources\Parents\Pages;

use App\Filament\Resources\Parents\ParentsResource;
use App\Models\User;
use Filament\Resources\Pages\CreateRecord;

class CreateParents extends CreateRecord
{
    protected static string $resource = ParentsResource::class;

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
