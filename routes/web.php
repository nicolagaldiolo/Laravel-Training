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

// Posso risolvere la rotta con una funzione anonima clousure o con un controller

Route::get('/', function () {
  return view('welcome');
});

// il namespace del controller viene definito nel RouteServiceProvider ossia: App\Http\Controllers
Route::get('/controller', 'welcomeController@index'); // nome_controller@nome_metodo


// i parametri ricaravi dall'url vengono automaticamente passati al metodo del controller
Route::get('/{name?}/{surname?}/{age?}', 'welcomeController@user')->where([
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
