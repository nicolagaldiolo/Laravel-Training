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

    // definisco l'array di colonne che devono essere gestite come oggetti data(=carbon) e non come stringhe
    // di default created_at e updated_at vengono nativamente gestite come oggetti carbon quindi la dichiarazione di queste due colonne è superflua
    // occorre specificarlo però per deleted_at in quanto abbiamo introddotto il soft deletes e dobbiamo informare laravel che questa colonne deve essere gestire come data
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
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
