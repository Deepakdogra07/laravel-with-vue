<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        
        \App\Models\User::factory()->create([
            'name' => 'superAdmin',
            'email' => 'superadmin@yopmail.com',
            'email_verified_at'=>'2024-03-25',
            'user_type' => 1,
            'status' => 1,
            'password' => Hash::make('123456'),
        ]);
        $this->call(Adding_job_description::class);
        $this->call(DummyDataEntry::class);
    }
}
