<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Album extends Model
{

    // Questo modello mappa la tabella albums del db

    //protected $table = 'inserire_nome_tabella'; // Laravel mappa automaticamente la classe alla tabella utilizzando il nome al singolare e con la prima lettera maiuscola, se non viene rispettato questo standard è comunque possibile specificare la proprietà del modello indicando la tabella:
    //protected $primarykey = 'nome_del_campo'; // Laravel fa la stessa cosa per la primarykey della tabella, se non fosse la colonna id posso specificare manualmente qual'è la chiave:
    protected $fillable = [ // dichiaro quali sono i campi riempibili
        'album_name',
        'description',
        'album_thumb',
        'user_id',
    ];

    // $album->path nella view mappa magicamente il metodo get|Path|Attribute() che torna il path dell'immagine
    // se creo un metodo in questo modo get|nome con 1° lettera maiuscola|Attribute posso accedere a questo metodo nel
    // controller o nella view
    public function getPathAttribute(){
        $url = $this->album_thumb;
        if(!stristr($url, 'http') || !stristr($url, 'https')){
            $url = 'storage/' . $url;
        }
        return $url;
    }


}
