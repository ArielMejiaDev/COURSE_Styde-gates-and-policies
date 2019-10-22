<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Post;
use App\User;
use Faker\Generator as Faker;

$factory->define(Post::class, function (Faker $faker) {
    return [
        'title'     =>  $faker->title(),
        'user_id'   =>  factory(User::class)->create()
    ];
});

$factory->state(Post::class, 'published', ['published' => 'published']);

$factory->state(Post::class, 'draft', ['published' => 'draft']);
