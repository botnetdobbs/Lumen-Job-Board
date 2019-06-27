<?php


$factory->define(App\Role::class, function (Faker\Generator $faker) {
    return [
        'name' => 'employer',
        'description' => 'creates jobs'
    ];
});
