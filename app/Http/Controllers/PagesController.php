<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use View; // Attenzione che questo dovrebbe essere un helper aggiuntivo generato da qualche plugin in quanto proviene da _ide_helper.php

class PagesController extends Controller
{
  
    protected $staff = array(
      [
        'name' => 'Nicola',
        'lastname' => 'Galdiolo'
      ],
      [
        'name' => 'Erica',
        'lastname' => 'Frigo'
      ],
      [
        'name' => 'Chloe',
        'lastname' => 'Galdiolo'
      ]
    );
  
  
  public function about(){
      
      // METODO 1
      return view('about'); // è un helper, una funzione globale di laravel
      
      /* RIPORTO LA DICHIARAZIONE DELL?HELPER A SCOPO DIMOSTRATIVO
       *
          function view($view = null, $data = [], $mergeData = []){
          
            // Chiamando la funzione global app che ha accesso al container passandogli la classe View come parametro
            // ottengo un istanza della classe view
            $factory = app(ViewFactory::class);
          
            if (func_num_args() === 0) {
              return $factory;
            }
          
            // una volta ottenutal'instanza della classe View chiamo il metodo make che mi torna la vista
            return $factory->make($view, $data, $mergeData);
          }
       */
      
      // METODO 2
      //return View::make('about');
      
      
      // faccio praticamente la stessa cosa del metodo del METODO 1 solo che chiamo staticamente la classe View
      // con il metodo make. PS: Devo prima aver importato il namespace con USE
      
      
    }
    
    
    public function staff(){
    
      $title = 'Our staff';
      $data = $this->staff;
      
      // METODO 1 | torno un array
      //return view('staffblade', [ 'title' => $title, 'data' => $this->staff, ]);
  
      // METODO 2 | utilizzo il metodo with della classe
      return view('staffblade')->with('title', $title)->with('data', $this->staff);
  
      // METODO 3 | utilizzo il metodo magico sfruttano il costrutto __call della classe viene eliminato with, la lettera maiuscola diventa minuscola e ciò che resta (title e data) sono i nomi delle variabili che vengono passate
      //return view('staffblade')->withTitle($title)->withData($this->staff);
  
      // METODO 4 | Faccio un compact (è il contrario dell'extract da una seria di variabili crea un array;) ottenendo lo stesso risultato del metodo 1
      //return view('staffblade', compact('title','data'));
      
    }
    
}
