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
        \App\Models\User::factory(1)->create(['email'=>'james@bond.com', 'password' => Hash::make(env('USER_LOGIN_PASSWORD','userpassword'))]);
        \App\Models\Category::factory(4)->create();
        $category = \App\Models\Category::factory()->create();
        \App\Models\Product::factory(20)->create(['category_id' => $category->id]);
        \App\Models\OrderStatus::factory()->create(['uuid'=>'54599e11-70fb-4deb-83d9-9a33a04b0705']);
        \App\Models\Payment::factory()->create(['uuid'=>'afb6c697-7ed3-4fe3-a7f4-615f21a576c1']);
    }
}
