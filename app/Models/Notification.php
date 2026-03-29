<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// Models
use App\Models\User;

class Notification extends Model
{
    protected $table = 'notifications';

    protected $fillable = [
        'title',
        'content',
        'is_read',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
