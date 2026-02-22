<?php

namespace App\Models\MasterData;

use Illuminate\Database\Eloquent\Model;

// Models
use App\Models\MasterData\Aspiration;

class AspirationImage extends Model
{
    protected $table = 'aspiration_images';

    protected $fillable = [
        'image_path',
        'aspiration_id',
    ];

    public function aspiration()
    {
        return $this->belongsTo(Aspiration::class, 'aspiration_id');
    }
}
