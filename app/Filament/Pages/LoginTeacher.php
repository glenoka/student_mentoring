<?php

namespace App\Filament\Pages;

use App\Models\User;
use Filament\Auth\Pages\Login ;
use Filament\Forms\Components\TextInput;
use Filament\Pages\Page;
use Filament\Schemas\Components\Component;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Filament\Auth\Http\Responses\Contracts\LoginResponse;


class LoginTeacher extends Login
{
    //protected string $view = 'filament.pages.login-teacher';
 
   

    public function authenticate(): ?LoginResponse
    {
        $data = $this->form->getState();

        // 🔥 Filter langsung: hanya user yang punya relasi teacher
        $user = User::where('username', $data['username'])
            ->whereHas('teacher')
            ->first();

        if (!$user) {
            throw ValidationException::withMessages([
            'data.username' => __('Username tidak ditemukan'),
        ]);
        }

        // 🔐 Attempt login
        if (!Auth::attempt([
            'username' => $data['username'],
            'password' => $data['password'],
        ], $data['remember'] ?? false)) {
            throw ValidationException::withMessages([
                'password' => 'Password salah',
            ]);
        }

       return app(LoginResponse::class);
    }
    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                $this->getUsernameFormComponent(),
                $this->getPasswordFormComponent(),
                $this->getRememberFormComponent(),
            ]);
    }
     protected function getUsernameFormComponent(): Component
    {
        return TextInput::make('username')
            ->label('Username')
            ->required()
            ->autocomplete()
            ->autofocus();
    }
    protected function getCredentialsFromFormData( array $data): array
    {
        return [
            'username' => $data['username'],
            'password' => $data['password'],
        ];
    }
    protected function throwFailureValidationException(): never
    {
        throw ValidationException::withMessages([
            'data.username' => __('Username dan Password yang anda masukkan salah'),
        ]);
    }
}
