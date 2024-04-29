<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class Adding_job_description extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Position::insert([
            ["name" => "Web Service"],
            ["name" => "Mechnanic"],
            ["name" => "Plumber"],
            ["name" => "Doctor"],

        ]);
        \App\Models\Skills::insert([
            ["name" => "Software Developer"],
            ["name" => "React Js "],
            ["name" => "Node js"],
            ["name" => "Laravel"],

        ]);
        \App\Models\Seniorities::insert([
            ["name" => "Entry Level"],
            ["name" => "Mid Level"],
            ["name" => "Senior Level"],

        ]);
        \App\Models\Industries::insert([
            ["name" => "IT"],
            ["name" => "Civil"],
            ["name" => "Mechanical"],
            ["name" => "Husbandry"],

        ]);
        \App\Models\Workexperience::insert([
            ["experience" => "0-1 Year"],
            ["experience" => "1-2 Year"],
            ["experience" => "2-3 Year"],
            ["experience" => "3-4 Year"],

        ]);
        \App\Models\Discipline::insert([
            ["name" => "Full Time"],
            ["name" => "Remote"],
            ["name" => "Hybrid"],
            ["name" => "Onsite"],

        ]);
    }
}
