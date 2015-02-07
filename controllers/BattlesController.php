<?php

namespace Controller;

//BlogController requires BaseController to render views
require_once 'BaseController.php';

class Battles extends Base
{
  // $battles property to hold battles model passed via instantiation
  private $battles;

  /**
   * Controller takes battles model as object and assigns it to controller property battles
   * @param [object] $battles
  */
  function __construct($battles)
  {
    $this->battles = $battles;
  }

  public function battlesDataAsJSON()
  {
    $battles = $this->battles->getBattles();
    echo(json_encode($battles));
  }
}