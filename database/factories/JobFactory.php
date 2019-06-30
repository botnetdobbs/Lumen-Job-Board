<?php


$factory->define(App\Job::class, function (Faker\Generator $faker) {
    return [
        'title' => 'Software Developer',
        'company' => 'Westwood inc',
        'location' => 'Nairobi',
        'employer_id' => 1,
        'job_description' => 'Expected to play a key role in the design, installation, testing and maintenance of our software systems',
        'application_email' => 'applications@westwood.inc'
    ];
});
