<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use \App\User;
use \App\Album;
use \App\Photo;

// Posso risolvere la rotta con una funzione anonima clousure o con un controller

Route::get('/', function () {
  return view('welcome');
});

// il namespace del controller viene definito nel RouteServiceProvider ossia: App\Http\Controllers
Route::get('/controller', 'welcomeController@index'); // nome_controller@nome_metodo


// i parametri ricaravi dall'url vengono automaticamente passati al metodo del controller
Route::get('welcome/{name?}/{surname?}/{age?}', 'welcomeController@user')->where([
    'name' => '[A-Za-z]+',
    'surname' => '[A-Za-z]+',
    'age' => '[0-9]{1,3}',
  ]);
  /*->where('name', '[A-Za-z]+')->where('surname', '[A-Za-z]+')*/
  // Condiziono le Route con regex aggiungiendo il metodo where e passando singolarmente le regex o con array chiave => valore o con stringa
  
  
Route::get('/php', function () {
  return view('test'); // posso anche tornare un file php anzichè un template con blade
});

Route::get('/string', function () {
  return "Questa è semplicemente una stringa";
});

Route::get('/json', function () {
  return ['Hello', 'World'];
});
/* ---- PROTEGGERE LE TORRE --- */
// posso proteggere le rotte in vari modi:

// 1: PROTEGGERE LE ROTTE SINGOLARMENTE Aggiungengo il metodo middleware in fondo alla rotta e passando il nome del middleware
// Route::get('/albums', 'AlbumsController@index' )->name('albums')->middleware('auth'); // con name definisco il nome della rotta, così se l'url dovesse cambiare il path di quella rotta, il riferimento rimane invariato, mi è comodo per i link o redirect.

// 2: PROTEGGO LE ROTTE A LIVELLO DI CONTROLLER

// 3: creo un GRUPPO DI ROTTE e le proteggo tutte sotto lo stesso middleware
Route::group(
    [
        'middleware' => 'auth',
        'prefix' => 'dashboard',
    ], function(){
    Route::get('/albums', 'AlbumsController@index' )->name('albums'); // con name definisco il nome della rotta, così se l'url dovesse cambiare il path di quella rotta, il riferimento rimane invariato, mi è comodo per i link o redirect.
    Route::post('/albums', 'AlbumsController@save' )->name('album.save');
    // sia per mostrare un singolo album, sia per eliminalo utilizzo lo stesso url ma pRoute::get('/albums', 'AlbumsController@index' )->name('albums')->middleware('auth'); // con name definisco il nome della rotta, così se l'url dovesse cambiare il path di quella rotta, il riferimento rimane invariato, mi è comodo per i link o redirect.er mostrare un album laravel si
    // aspetta una chiamata via get, mentre per eliminarlo devo necessariamente fare una chiamata delete

    //Route::get('/albums/{album}', 'AlbumsController@show' )->where('album', '[0-9]+')->middleware('can:test,album'); // posso proteggere la rotta anche con un middleware invocando il metodo test della policy passando l'oggetto album che mi viene fornito dal metodo show del controller visto che faccio il model binding
    Route::get('/albums/{album}', 'AlbumsController@show' )->where('album', '[0-9]+');

    Route::get('/albums/{album}/images', 'AlbumsController@getImages' )->where('id', '[0-9]+')->name('albumImages');
    Route::get('/albums/create', 'AlbumsController@create' )->name('album.create');
    Route::delete('/albums/{id}', 'AlbumsController@delete' )->name('album.delete');
    Route::patch('/albums/{id}', 'AlbumsController@update' )->name('album.update');

    Route::resource('photos', 'PhotosController'); // In automatico laravel mi crea tutte le rotte necessarie per gestire il crud, basta lanciare $ php artisan route:list per vedere l'elenco delle rotte create
    Route::get('/users', function () {
        return User::all();
    });
    Route::get('/usersnoalbum/', function(){
        $usernoalbum = DB::table('users as u')
            ->select('u.id', 'u.email', 'u.name')
            ->leftJoin('albums as a', 'u.id', 'a.user_id')
            ->whereNull('a.album_name') // laravel mi mette a disposizione una serie di metodi ad esempio per controllare al volo se il valore passato è null
            //->where('a.album_name', '=', 'null') // oppure posso dichiarare la condizione classica (nel caso di uguale non serve passare il parametro di confronto)
            //->whereRaw('a.album_name is null') // oppure posso scrivere la query grezza se devo fare qualcosa di particolare e non ho un metodo per farlo
            ->get();

        return $usernoalbum;
    });
});


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
