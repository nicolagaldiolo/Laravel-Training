<?php

use Illuminate\Database\Seeder;
use App\Album;

class SeedAlbumTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

      DB::statement('SET FOREIGN_KEY_CHECKS=0');
      Album::truncate();

      factory(Album::class, 20)->create();
    }
}
