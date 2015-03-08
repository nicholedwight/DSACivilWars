<?php

/**
 * Controls which page should be displayed.
 *
 * This controller extends the base controller
 * and contains different functions for retrieving
 * battle information from the model.
 */

namespace Controller;

//PageController requires BaseController to render views
require_once 'BaseController.php';

class Page extends Base
{
  /** Property to hold battles model passed via instantiation.
  */
  private $battles;

  /**
   * Controller takes array consisting of the comments
   * and battles models as an object and assigns it to
   * controller property comments and battles. Magic method construct
   * is invoked upon instantiation of this class Page.
   * @param array $models Array containing the
   * models instantiated in the index
  */
  function __construct($models)
  {
    $this->battles = $models['battles'];
    $this->comments = $models['comments'];
  }

  /**
   * Controller method for retrieving battles from the
   * battles model, rendering the header with chosen battle
   * and including the map and modal to the page.
   */
  public function mapHomePage()
  {
    // Gets battles from battles model.
    $battles = $this->battles->getBattles();
    $this->renderHeader($battles);
    include 'views/templates/map.php';
    include 'views/templates/modal.php';
    $this->renderFooter($battles);
  }

  /**
   * Controller method for retrieving the battle page
   * @param integer $id Unique id given to each battle
   */
  public function battlePage($id) {
    // Gets battles from battles model and comments from comments model.
    $factions = $this->battles->getFactionsByBattleId($id);
    $battle = $this->battles->getBattleById($id);
    $battles = $this->battles->getBattles();
    $this->renderHeader($battles);
    include 'views/templates/battle-details.php';
    $this->renderFooter($battles);
  }
}
