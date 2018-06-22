<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public function Album(){
        return $this->belongsToMany(Album::class);
    }
}
