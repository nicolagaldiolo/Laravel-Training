<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request; // oggetto laravel contenente la request

class welcomeController extends Controller
{
    function index(Request $req){ // posso passare come parametro l'oggetto request messo a disposizione da laravel
      
      var_dump($req);
      
      return 'Posso chiamare una view o stampare qualcosa';
    }
  
    function user($name = '', $surname = '', $age = 0){
      return "<h1>Hello {$name} {$surname}, You are {$age} years old</h1>";
    }
}
