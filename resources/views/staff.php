<?php
  echo "<h1>Pagina in PHP</h1>";
  if($title){
    echo "<h2>{$title}</h2>";
  }
  if(!empty($data)) {
    echo "<ul>";
    
    foreach ($data as $member) {
      echo "<li>{$member['name']} {$member['lastname']}</li>";
    }
    
    echo "</ul>";
  }
?>