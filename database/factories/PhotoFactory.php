<?php
  use Faker\Generator as Faker;
  use App\Photo;
  use App\Album;
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

  $factory->define(Photo::class, function (Faker $faker) { // definisco il modello da usare e la funzione da eseguire

    $randomCat = array(
      'animals',
      'city',
      'sports'
    );

    return [
      'name'          => $faker->text(64),
      'description'   => $faker->text(128),
      'img_path'      => $faker->imageUrl(1000, 800, $faker->randomElement($randomCat)),
      'album_id'      => Album::inRandomOrder()->first()->id,
      'created_at'    => Carbon::now()
    ];
  });
