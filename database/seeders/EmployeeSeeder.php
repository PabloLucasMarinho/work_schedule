<?php

namespace Database\Seeders;

use App\Models\Employee;
use App\Models\Schedule;
use Illuminate\Database\Seeder;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Employee::factory()
            ->count(10)
            ->has(Schedule::factory()->count(3))
            ->create();
    }
}
