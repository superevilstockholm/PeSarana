<?php

namespace App\Models\MasterData;

use Illuminate\Database\Eloquent\Model;

// Models
use App\Models\User;
use App\Models\MasterData\Aspiration;

// Enums
use App\Enums\AspirationStatusEnum;

class AspirationFeedback extends Model
{
    protected $table = 'aspiration_feedbacks';

    protected $fillable = [
        'description',
        'status',
        'user_id',
        'aspiration_id',
    ];

    protected $casts = [
        'status' => AspirationStatusEnum::class,
    ];

    public function aspiration()
    {
        return $this->belongsTo(Aspiration::class, 'aspiration_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
