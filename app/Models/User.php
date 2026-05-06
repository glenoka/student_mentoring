<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Filament\Panel;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Traits\HasRoles;
use Filament\Models\Contracts\FilamentUser;

#[Fillable(['name', 'email', 'password'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable implements FilamentUser

{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, HasRoles;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected  $fillable = [
        'name',
        'username',
        'email',
        'password',
    ];
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
     public function teacher()
    {
        return $this->hasOne(teachers::class);
    }

    public function parent()
    {
        return $this->hasOne(parents::class);
    }
    public function mentoringSessions()
{
    return $this->hasMany(MentoringSession::class);
}
public function getRoleNameAttribute()
{
    return $this->getRoleNames()->implode(', ');
}
public function canAccessPanel(Panel $panel): bool
{
    if ($panel->getId() === 'admin') {
        return $this->teacher()->exists();
    }

    if ($panel->getId() === 'parent') {
        return $this->parent()->exists();
    }

    return false;
}
}
