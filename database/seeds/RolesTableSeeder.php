<?php

use Illuminate\Database\Seeder;
use App\Role;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Role::class)->create(['name' => 'employer', 'description' => 'Posts jobs on the application']);
        factory(Role::class)->create(['name' => 'applicant', 'description' => 'Locates and applies for jobs in the application']);
    }
}
