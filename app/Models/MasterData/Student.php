<?php

namespace App\Models\MasterData;

use Illuminate\Database\Eloquent\Model;

// Models
use App\Models\User;
use App\Models\MasterData\Classroom;
use App\Models\MasterData\Aspiration;

class Student extends Model
{
    protected $table = 'students';

    protected $fillable = [
        'nisn',
        'name',
        'dob',
        'classroom_id',
        'user_id',
    ];

    protected $casts = [
        'dob' => 'date',
    ];

    public function classroom()
    {
        return $this->belongsTo(Classroom::class, 'classroom_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function aspirations()
    {
        return $this->hasMany(Aspiration::class, 'student_id');
    }
}
