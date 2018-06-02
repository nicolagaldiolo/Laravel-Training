<?php

  use Faker\Generator as Faker;
  use App\Album;
  use App\User;
  use Carbon\Carbon;
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

  $factory->define(Album::class, function (Faker $faker) { // definisco il modello da usare e la funzione da eseguire

      $randomCat = array(
          'animals',
          'city',
          'sports'
      );

      return [
      'album_name'  => $faker->name,
      'description' => $faker->text(128),
      'album_thumb' => $faker->imageUrl(800, 800, $faker->randomElement($randomCat)),
      'user_id'     => User::inRandomOrder()->first()->id, // utilizzo il model User per farmi tornare in ordine random il primo id di un album
      'created_at'  => Carbon::now()
    ];
  });
