<?php

namespace App;
use App\Photo;
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

    // mentre se creo un metodo sfruttuando i metodi magici getter, setter con la sintassi get|nomecampodbinCamelCase|Attribute():
    // questo metodo viene invocato ogni volta che voglio accedere a questo attrbituo
    public function getAlbumThumbAttribute($value){
        // model accessor
        if(!stristr($value, 'http') || !stristr($value, 'https')){
            $value = 'storage/' . $value;
        }
        return $value;
    }

    public function photos(){ // questo è il metodo che dichiara la relazione, quando ho bisogno delle foto di un album chiamo questo metodo

        // il primo parametro è il nome della tabella con cui relazioniamo, il secondo campo è la chiave esterna, mentre il terzo parametro è la chiave della tabella corrente con cui fare il match
        // laravel di default cerca come foreignKey nometabella_id e come localKey il campo id quindi in questo caso viene rispettato lo standard ed il 2° e 3° parametro sono superflui
        return $this->hasMany(Photo::class); // $this->hasMany(Photo::class, 'album_id', 'id');
    }


}
