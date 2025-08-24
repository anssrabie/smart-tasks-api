<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('statuses')->insert([
            ['name' => 'Pending', 'value' => 'pending'],
            ['name' => 'In Progress', 'value' => 'in_progress'],
            ['name' => 'Completed', 'value' => 'completed'],
        ]);
    }
}
