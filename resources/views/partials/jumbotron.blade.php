{{-- a differenza del components un alert eredita le variabili definite nello scope globale (parent)
vedi la variabile title, mentre come con i components posso passare un array di dati , vedi var $contenuto
ma non posso passare un contenuto slot --}}

<div class="jumbotron">
  @if($title)
    <h1 class="display-4">{{$title}}</h1>
  @endif
  @if($contenuto)
    <p class="lead">{{$contenuto}}</p>
  @endif
</div>