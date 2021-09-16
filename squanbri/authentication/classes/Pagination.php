<?php namespace Squanbri\Authentication\Classes;

use Input;

class Pagination 
{ 
  public $array;

  function __construct($array) {
    $this->array = $array;
  }

  public function pagination() {
    $page = Input::get('page') ?? 0;
    $offset = Input::get('offset') ?? 4;

    for ($i = $page * $offset; $i < $page * $offset + $offset; $i++) 
    { 
      if (isset($this->array[$i])) {
        $newArr[] = $this->array[$i];
      }
    }
    
    $this->array = $newArr ?? [];

    return $this->array;
  }
}

?>