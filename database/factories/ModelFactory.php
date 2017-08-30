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
$factory->define(Sijot\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(Sijot\Activity::class, function (Faker\Generator $faker) {
    return [
        'group_id' => function () {
             return factory(Sijot\Groups::class)->create()->id;
        },
        'status' => $faker->word,
        'title' => $faker->word,
        'description' => $faker->word,
        'activiteit_datum' => '',
        'start_hour' => '',
        'end_hour' => '',
        'deleted_at' => '',
    ];
});

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(Sijot\Categories::class, function (Faker\Generator $faker) {
    return [
        'author_id' => function () {
             return factory(Sijot\User::class)->create()->id;
        },
        'module' => $faker->word,
        'name' => $faker->name,
        'description' => $faker->text,
    ];
});

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(Sijot\Events::class, function (Faker\Generator $faker) {
    return [
        'status' => $faker->randomNumber(),
        'author_id' => function () {
             return factory(Sijot\User::class)->create()->id;
        },
        'title' => $faker->word,
        'description' => $faker->word,
        'end_date' => '',
        'end_hour' => '',
        'start_date' => '',
        'start_hour' => '',
    ];
});

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(Sijot\Groups::class, function (Faker\Generator $faker) {
    return [
        'selector' => $faker->word,
        'title' => $faker->word,
        'sub_title' => $faker->word,
        'description' => $faker->text,
    ];
});

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(Sijot\Lease::class, function (Faker\Generator $faker) {
    return [
        'status_id' => $faker->randomNumber(),
        'groeps_naam' => $faker->word,
        'contact_email' => $faker->word,
        'tel_nummer' => $faker->word,
        'eind_datum' => $faker->dateTimeBetween(),
        'start_datum' => $faker->dateTimeBetween(),
    ];
});

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(Sijot\News::class, function (Faker\Generator $faker) {
    return [
        'author_id' => function () {
             return factory(Sijot\User::class)->create()->id;
        },
        'title' => $faker->word,
        'publish' => $faker->word,
        'message' => $faker->text,
    ];
});

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(Sijot\Themes::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'class' => $faker->word,
    ];
});

$factory->define(Sijot\LeaseAdmin::class, function (Faker\Generator $faker) {
    return [
        'persons_id' => function () {
             return factory(Sijot\User::class)->create()->id;
        },
        'info' => $faker->text,
    ];
});

$factory->define(Sijot\Notitions::class, function (Faker\Generator $faker) {
    return [
        'author_id' => function () {
             return factory(Sijot\User::class)->create()->id;
        },
        'text' => $faker->text,
    ];
});

$factory->define(Sijot\Permission::class, function (Faker\Generator $faker) {
    return [
        'author_id' => function () {
             return factory(Sijot\User::class)->create()->id;
        },
        'system_permission' => $faker->word,
        'name' => $faker->name,
        'description' => $faker->text,
    ];
});

$factory->define(Sijot\Photos::class, function (Faker\Generator $faker) {
    return [
        'author_id' => function () {
             return factory(Sijot\User::class)->create()->id;
        },
        'title' => $faker->word,
        'image_path' => $faker->word,
        'url' => $faker->url,
        'description' => $faker->text,
    ];
});

$factory->define(Sijot\Role::class, function (Faker\Generator $faker) {
    return [
        'author_id' => function () {
             return factory(Sijot\User::class)->create()->id;
        },
        'system_role' => $faker->word,
        'name' => $faker->name,
        'description' => $faker->text,
    ];
});

$factory->define(Chrisbjr\ApiGuard\Models\ApiKey::class, function (Faker\Generator $faker) {
    return [
        'apikeyable_id' => function () {
            return factory(Sijot\User::class)->create()->id;
        },
        'apikeyable_type' => 'Sijot\User',
        'key' => str_random(50),
        'last_ip_address' => $faker->ipv4,
        'service' => $faker->name,
    ];
});

$factory->define(Sijot\Notitions::class, function (Faker\Generator $faker) {
    return [
        'author_id' => function () {
            return factory(Sijot\User::class)->create()->id;
        },
        'text' => $faker->paragraph(),
    ];
});

