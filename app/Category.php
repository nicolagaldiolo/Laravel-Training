<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{

    //protected $fillable = ['title', 'category_id', 'preview', 'body']; // definisco i campi che posso riempire
    protected $guarded = [];

    public function Album(){
        return $this->belongsToMany(Album::class)
            ->withTimestamps(); // con withTimestamps vado anche a popolare i campi di creazione e aggiornamento
    }

    public function User(){
        return $this->belongsTo(User::class);
    }
}
