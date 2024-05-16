<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LanguageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Language::insert([
            ["language_name" => "English"],
            ["language_name" => "Czech"],
            ["language_name" => "Spanish"],
            ["language_name" => "Hindi"],
            ["language_name" => "Urdu"],
        ]);
    }
}
