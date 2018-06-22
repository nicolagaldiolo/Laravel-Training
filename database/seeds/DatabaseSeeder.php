<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Album;
use App\Photo;
use App\Category;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        $me = User::create(
            [
                'name' => env('TEST_USER_NAME'),
                'email' => env('TEST_USER_EMAIL'),
                'password' => bcrypt(env('TEST_USER_PASSWORD'))

            ]
        );

        //Alimento la tabella, utilizzando una Factory
        $users = factory(User::class, 9)->create();
        $users->push($me);

        $categories = factory(Category::class, 40)->create();

        $users->each(function($user) use($categories){
            $albums = factory(Album::class, 10)->create([
                'user_id' => $user->id,
            ])->each(function($album) use($categories){
                $photos = factory(Photo::class, 20)->create([
                    'album_id' => $album->id,
                ]);

                $randomCategories = $categories->random(3)->pluck('id')->toArray();
                $album->categories()->sync($randomCategories);
            });

        });


        //$this->call(SeedAlbumTable::class);
        //$this->call(SeedPhotoTable::class);

    }
}
