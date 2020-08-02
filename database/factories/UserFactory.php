<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Article;
use App\Category;
use App\Gallery;
use App\Product;
use App\Productlike;
use App\Productview;
use App\User;
use App\Video;
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

$factory->define(User::class, function (Faker $faker) {
    return [
        'username' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'email_verified_at' => now(),
        'password' => encrypt(123456), // password
        'remember_token' => Str::random(10),
    ];
});
$factory->define(Category::class, function (Faker $faker) {
    return [
        'title' => $faker->jobTitle,
    ];
});
$factory->define(Product::class, function (Faker $faker) {
    return [
        'title' => $faker->jobTitle,
        'price' => $faker->randomDigit,
        'slug' => $faker->streetName,
        'status' => $faker->boolean(20),
        'text' => $faker->text(500),
        'url' => $faker->imageUrl(300,300)
    ];
});
$factory->define(Article::class, function (Faker $faker) {
    return [
        'title' => $faker->streetName,
        'slug' => $faker->streetName,
        'isPublish' => $faker->boolean(20),
        'publish_date' => $faker->dateTime,
        'body' => $faker->text(10000),
        'url' => $faker->imageUrl(300,300)
    ];
});
$factory->define(Video::class, function (Faker $faker) {
    return [
        'title' => $faker->title,
        'isPublish' => $faker->boolean(20),
        'slug' => $faker->streetName,
        'publish_date' => $faker->dateTime,
        'text' => $faker->text(1000),
        'picUrl' => $faker->imageUrl(300,300)
    ];
});
$factory->define(Gallery::class, function (Faker $faker) {
    return [
        'url' => $faker->imageUrl(640,640)
    ];
});
$factory->define(Productlike::class, function (Faker $faker) {
    return [
        'like' => $faker->boolean(2),
        'ip' => $faker->ipv4
    ];
});
$factory->define(Productview::class, function (Faker $faker) {
    return [
        'ip' => $faker->ipv4
    ];
});
