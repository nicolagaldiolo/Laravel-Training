<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Album;
use App\User;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        //'App\Model' => 'App\Policies\ModelPolicy',
        'App\Album' => 'App\Policies\AlbumPolicy',
        'App\Photo' => 'App\Policies\PhotoPolicy'
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //

        // Definisco un gate, una porta che mi dice in questo caso se l'utente può gestire questa risorsa
        // LO USER MI VIENE AUTOMATICAMENTO INIETTATO DA LARAVEL, noi passiamo solo l'istanza dell album quando chiamiamo
        // il gate manage-album

        /*Gate::define('manage-album', function(User $user, Album $album){
            return $user->id === $album->user->id;
        });*/

    }
}
