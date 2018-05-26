<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAlbumTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('albums', function (Blueprint $table) {
            $table->increments('id');
            $table->string('album_name', 128);
            $table->text('description');
            // inserisco un campo che fa riferimento all'id dell'utente
            $table->integer('user_id')->unsigned();
            // inserisco una chiave esterna sul campo user_id precedentemente creato dicendo che fa riferimento al capo id
            // della tabella users e se questo id utente viene eliminato o aggiornato rispettivamente anche l'album viene eliminato o aggiornato l'id
            $table->foreign('user_id')->on('users')->references('id')->onDelete('cascade')->onUpdate('cascade');
            // aggiungendo softdelete dichiaro che il record non viene fisicamente eliminato ma semplicemente marcato come eliminato
            // e quindi risulta eliminato sebbene non lo è
            $table->softDeletes();
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('albums');
    }
}
