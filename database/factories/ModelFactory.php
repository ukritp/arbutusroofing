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

$factory->define(App\User::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->safeEmail,
        'password' => bcrypt(str_random(10)),
        'remember_token' => str_random(10),
    ];
});


// COMPANY FACTORY
$factory->define(App\Company::class, function (Faker\Generator $faker) {
    // $user_ids = \DB::table('users')->select('id')->get();
    // $user_id = $faker->randomElement($user_ids)->id;
    $user_id = $faker->randomElement([1,4,5,6]);
    $city = $faker->randomElement($array = array ('Vancouver','Burnaby','Surrey','Richmond','Delta','North Vancouver',
        'Coquitlam','Langley'));
    $initial_number = $faker->randomElement($array = array ('604','778'));
    return [
        'company_name' => $faker->company,
        'label'        => $faker->word,
        'first_name'   => $faker->firstName,
        'last_name'    => $faker->lastName,
        'address'      => $faker->streetAddress,
        'city'         => $city,
        'province'     => 'BC',
        'postalcode'   => 'V'.$faker->randomDigit.$faker->randomLetter.$faker->randomDigit.$faker->randomLetter.$faker->randomDigit,
        'phone_number' => $initial_number.$faker->numerify('#######'),
        'user_id'      => $user_id,
    ];
});

// PROPERTY FACTORY
$factory->define(App\Property::class, function (Faker\Generator $faker) {
    $city = $faker->randomElement($array = array ('Vancouver','Burnaby','Surrey','Richmond','Delta','North Vancouver',
        'Coquitlam','Langley'));
    $initial_number = $faker->randomElement($array = array ('604','778'));
    return [
        'property_name' => $faker->company,
        'first_name'   => $faker->firstName,
        'last_name'    => $faker->lastName,
        'address'      => $faker->streetAddress,
        'city'         => $city,
        'province'     => 'BC',
        'postalcode'   => 'V'.$faker->randomDigit.$faker->randomLetter.$faker->randomDigit.$faker->randomLetter.$faker->randomDigit,
        'phone_number' => $initial_number.$faker->numerify('#######'),
    ];
});