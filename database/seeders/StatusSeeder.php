<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $statuses = [
            ['name' => 'Pending', 'value' => 0],
            ['name' => 'Approved', 'value' => 1],
            ['name' => 'Rejected', 'value' => 2],
            ['name' => 'Incomplete', 'value' => 3],
            ['name' => 'FullComplete', 'value' => 4],
            ['name' => 'Re-Apply', 'value' => 5],
            ['name' => 'Transferred' , 'value' => 6]
        ];

        DB::table('status')->insert($statuses);
    }
}
