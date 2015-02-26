<?php

namespace Controller;

//BlogController requires BaseController to render views
require_once 'BaseController.php';

class Page extends Base
{
  // $battles property to hold battles model passed via instantiation
  private $battles;

  /**
   * Controller takes array consisting of the comments and battles models as an object and assigns it to controller property comments and battles
   * @param [object] $battles
  */
  function __construct($models)
  {
    $this->battles = $models['battles'];
    $this->comments = $models['comments'];
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
    include 'views/templates/modal.php';
    $this->renderFooter();
  }

  /**
   * Controller method for map homepage, query $db, fetch array, create view.
  */
  public function battlePage($id) {
    // Gets battles from battles model and comments from comments model.
    $factions = $this->battles->getFactionsByBattleId($id);
    $battle = $this->battles->getBattleById($id);
    $commentRows = $this->comments->getAllCommentsByBattleID($id);
    $this->renderHeader();
    include 'views/templates/battle-details.php';
    $this->renderFooter();
  }
}
