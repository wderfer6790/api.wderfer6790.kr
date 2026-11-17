<?php

namespace Database\Seeders;

use App\Models\{User, Article, Reply, File};
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        File::factory(20)->create();

        User::factory(10)->create();

        Article::factory(100)->create();

        Reply::factory(200)->create();

    }
}
