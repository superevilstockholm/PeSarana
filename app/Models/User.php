<?php

namespace App\Models;

use Illuminate\Support\Facades\Storage;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

// Enums
use App\Enums\RoleEnum;

// Models
use App\Models\Notification;
use App\Models\MasterData\Student;
use App\Models\MasterData\AspirationFeedback;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'profile_picture_path',
    ];

    protected $appends = [
        'profile_picture_path_url'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'role' => RoleEnum::class,
        ];
    }

    public function getProfilePicturePathUrlAttribute(): string
    {
        /** @var \Illuminate\Contracts\Filesystem\FilesystemAdapter $public_disk */
        $public_disk = Storage::disk('public');
        return $this->profile_picture_path
            ? $public_disk->url($this->profile_picture_path)
            : asset('static/img/default-profile-picture.svg');
    }

    public function student()
    {
        return $this->hasOne(Student::class);
    }

    public function aspiration_feedbacks()
    {
        return $this->hasMany(AspirationFeedback::class);
    }

    public function notifications()
    {
        $this->hasMany(Notification::class);
    }
}
