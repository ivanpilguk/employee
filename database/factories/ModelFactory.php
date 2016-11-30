<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Employee::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->firstName(),
        'surname' => $faker->lastName(),
        'middlename' => $faker->firstName(),
        'work_from' => $faker->dateTimeThisDecade(),
        'salary' => floatval($faker->numberBetween(1000,9000)),
        'post_id' => function () {
            $post=App\Post::inRandomOrder()->first();
            return $post?$post->id:null;
        },
    ];
});

$factory->define(App\Post::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->jobTitle(),
    ];
});