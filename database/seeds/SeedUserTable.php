<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use App\User;

class SeedUserTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        // disabilito il controllo sulle chiavi esterne altrimenti non riesco a cancellare questi record
        // abilito il FOREIGN_KEY_CHECKS anche nel singolo Seeder e non solo nel DatabaseSeeder così posso lanciare questo seed singolarmente senza problemi
        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        User::truncate(); // tronco la tabella users se ci sono dati così posso lanciare il seed + volte



        //Alimento la tabella, utilizzando una Factory
        factory(User::class, 70)->create();
        // come primo parametro passo il nome del modello, il numero di volte che deve essere eseguito e il metodo create scrive
        // fisicamente sul db, mentre se volessi semplicemente tornare dei dati posso usare il metodo make().


        //Altrimenti alimento la tabella, in maniera manuale
/*
        // uso lo statement
        $sql = "INSERT INTO users (name, email, password, created_at) values (:name, :email, :password, :created_at)";
        for($i=0; $i<=30; $i++) {
          DB::statement($sql, [
            'name' => 'Nicola' . $i,
            'email' => 'galdiolo.nicola' . $i . '@gmail.com',
            'password' => bcrypt('password'),
            'created_at' => Carbon::now(), // date("Y-m-d H:i:s")
          ]);
        }
*/
    }
}
