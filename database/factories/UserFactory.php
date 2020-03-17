<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Article;
use App\Comment;
use App\User;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/


$factory->define(Article::class, function (Faker $faker) {
    return [
        'user_id'=> App\User::all()->random()->id,
        'category_id'=>App\Category::all()->random()->id,
        'title' => $faker->sentence(6, true),
        'description' => $faker->paragraph(10, true),
        'created_at'=> $faker->dateTimeBetween('-1 years', 'now'),
        'updated_at'=> $faker->dateTimeBetween('-1 years', 'now'),
    ];
});

$factory->define(Comment::class, function (Faker $faker) {
    return [
        'article_id' => App\Article::all()->random()->id,
        'nickname' => $faker->name,
        'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm',
        'description' => $faker->paragraph(5, true),
        'created_at'=> $faker->dateTimeBetween('-1 years', 'now'),
        'updated_at'=> $faker->dateTimeBetween('-1 years', 'now'),

    ];
});


