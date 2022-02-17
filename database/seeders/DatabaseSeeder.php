<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::factory(1)->create(['email'=>'james@bond.com', 'password' => Hash::make('password')]);
        \App\Models\Category::factory(20)->create();
    }
}
