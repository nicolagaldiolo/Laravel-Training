<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function getFullnameAttribute(){
        return $this->name . ' (' . $this->email . ')';
    }

    public function Categories(){
        return $this->hasMany(Category::class);
    }

    public function Albums(){
        return $this->hasMany(Album::class);
    }
}
