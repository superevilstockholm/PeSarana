<?php

namespace App\Models\MasterData;

use Illuminate\Database\Eloquent\Model;

// Models
use App\Models\MasterData\Student;
use App\Models\MasterData\Category;
use App\Models\MasterData\AspirationFeedback;

// Enums
use App\Enums\AspirationStatusEnum;

class Aspiration extends Model
{
    protected $table = 'aspirations';

    protected $fillable = [
        'title',
        'description',
        'location',
        'status',
        'student_id',
        'category_id',
    ];

    protected $casts = [
        'status' => AspirationStatusEnum::class,
    ];

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function feedbacks()
    {
        return $this->hasMany(AspirationFeedback::class, 'aspiration_id');
    }
}
