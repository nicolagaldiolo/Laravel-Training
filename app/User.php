<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;
    use SoftDeletes; //in questo modo abilito il softdelete, in modo che i record vengano SOLO marcati come cancellati

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

    public function isAdmin(){ // creo un metodo che mi dice se l'utente è amministratore
        return $this->role == env('USER_ADMIN_ROLE');
    }
}
