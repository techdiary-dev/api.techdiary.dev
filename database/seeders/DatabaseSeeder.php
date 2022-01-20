<?php

namespace Database\Seeders;

use App\Models\Series;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::factory()
            ->count(20)
//            ->hasArticles(30)
            ->create();

//        Series::factory()->count(5)->create();

//        Article::factory()->count(50)->create();
        //  Tag::factory(50)->create();
    }


}
