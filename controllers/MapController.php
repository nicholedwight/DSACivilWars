<?php

namespace Controller;

//BlogController requires BaseController to render views
require 'BaseController.php';

class Map extends Base
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

  /**
   * Controller method for map homepage, query $db, fetch array, create view.
  */
  public function mapHomePage()
  {
    // Gets battles from battles model.
    $battles = $this->battles->getBattles();
    $this->renderHeader();
    include 'views/templates/map.php';
    $this->renderFooter();
  }

  public function battlesDataAsJSON()
  {
    $battles = $this->battles->getBattles();
    echo(json_encode($battles));
  }

  /**
   * Controller for 404 view
   * This view show when no page/view can be found
  */
  public function pageNotFound()
  {
    $this->renderHeader();
    include 'views/templates/404.php';
  }
}