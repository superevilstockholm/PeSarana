<?php

namespace App\Models\MasterData;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

// Models
use App\Models\MasterData\Aspiration;

class AspirationImage extends Model
{
    protected $table = 'aspiration_images';

    protected $fillable = [
        'image_path',
        'aspiration_id',
    ];

    protected $appends = [
        'image_path_url'
    ];

    public function getImagePathUrlAttribute(): string
    {
        /** @var \Illuminate\Contracts\Filesystem\FilesystemAdapter */
        $public_disk = Storage::disk('public');
        return $this->image_path
            ? $public_disk->url($this->image_path)
            : asset('static/img/no-image-placeholder.svg');
    }

    public function aspiration()
    {
        return $this->belongsTo(Aspiration::class, 'aspiration_id');
    }
}
