<?php

use Illuminate\Database\Seeder;
use App\Photo;

class SeedPhotoTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        Photo::truncate();

        factory(Photo::class, 500)->create();
    }
}
