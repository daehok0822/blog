<?php

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
        $this->call(UsersTableSeeder::class);

        $this->call(ArticlesTableSeeder::class);
        $this->command->info('article table seeded');

        $this->call(CategoriesTableSeeder::class);
        $this->command->info('category table seeded');

        $this->call(CommentsTableSeeder::class);
        $this->command->info('comment table seeded');
    }
}
