<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

// Models
use App\Models\User;
use App\Models\MasterData\Student;
use App\Models\MasterData\Category;
use App\Models\MasterData\Classroom;

// Enums
use App\Enums\RoleEnum;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Admin user
        User::updateOrCreate([
            'email' => config('admin.email'),
        ], [
            'name' => config('admin.name'),
            'email' => config('admin.email'),
            'password' => Hash::make(config('admin.password')),
            'role' => RoleEnum::ADMIN,
            'email_verified_at' => now(),
        ]);

        // Classroom
        Classroom::updateOrCreate([
            'name' => 'XII RPL 3',
        ], [
            'name' => 'XII RPL 3',
        ]);

        // Student
        Student::updateOrCreate([
            'nisn' => '0012345678',
        ], [
            'nisn' => '0012345678',
            'name' => 'Hillary Aimee Srijaya',
            'dob' => '2008-06-23',
            'classroom_id' => 1,
        ]);

        // Category
        Category::updateOrCreate([
            'name' => 'Wifi & Internet',
        ], [
            'name' => 'Wifi & Internet',
        ]);
    }
}
