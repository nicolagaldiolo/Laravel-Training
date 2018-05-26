<?php

  namespace App;
  use Illuminate\Database\Eloquent\Model;

  class Album extends Model{

    // Questo modello mappa la tabella users del db
    // Laravel mappa automaticamente la classe alla tabella utilizzando il nome al singolare e con la prima lettera maiuscola,
    // se non viene rispettato questo standard è comunque possibile specificare la proprietà del modello indicando la tabella:
    //protected $table = 'inserire_nome_tabella';



  }
