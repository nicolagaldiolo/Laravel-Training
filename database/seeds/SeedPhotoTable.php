<?php

use Illuminate\Database\Seeder;
use App\Photo;
use App\Album;

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

        $albums = Album::get(); // ottengo un array con tutti gli album

        // NB: la factory (per come è stata fatta) crea di default le foto assegnando un album_id random,
        // ma quando la chiamiamo, posso passare un array come parametro al metodo create dove sovrascrivo alcuni o
        // tutti i campi del db
        // In questo caso ciclo gli album e per ogni album creo 200 foto, passando ad ogni iterazione l'id dell'album corrente
        // socrascrivendo l'album id con lid dell'album che sto iterando.

        foreach ($albums as $album){
            factory(Photo::class, 200)->create(
                ['album_id' => $album->id]
            );
        }
    }
}
