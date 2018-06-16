<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{


    // creo la relazione tra la foto e l'album dichiarando che una foto appartiene ad un album
    public function album(){
        // ritorno una relazione
        //return $this->belongsTo(Album::class, 'album_id', 'id');
        return $this->belongsTo(Album::class); // non serve passare la chiave esterna e l'id perchè rispecchiano già lo standard
    }


    // $album->path nella view mappa magicamente il metodo get|Path|Attribute() che torna il path dell'immagine
    // se creo un metodo in questo modo get|nome con 1° lettera maiuscola|Attribute posso accedere a questo metodo nel
    // controller o nella view
    public function getPathAttribute(){
        $url = $this->img_path;
        if(!stristr($url, 'http') || !stristr($url, 'https')){
            $url = 'storage/' . $url;
        }
        return $url;
    }
    // mentre se creo un metodo sfruttuando i metodi magici getter, setter con la sintassi get|nomecampodbinCamelCase|Attribute():
    // questo metodo viene invocato ogni volta che voglio accedere a questo attrbituo
    public function getImgPathAttribute($value){
        // model accessor
        if(!stristr($value, 'http') || !stristr($value, 'https')){
            $value = 'storage/' . $value;
        }
        return $value;
    }

    // questo metodo viene invocato automaticamente quando tento di settare questo attributo
    public function setNameAttribute($value){
        // model mutator
        $this->attributes['name'] = strtoupper($value);
    }

}
