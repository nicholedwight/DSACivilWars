<?php

/**
 * Displays battle data in JSON and RSS format.
 *
 * This controller extends the base controller
 * and contains different functions for retrieving
 * battle information from the model in JSON and RSS format.
 */

namespace Controller;

require_once 'BaseController.php';

class Resource extends Base
{
  /** Property to hold battles model passed via instantiation.
  */
  private $battles;

  /**
  * Magic method construct gets invoked upon instantiation
  * the battles parameter gets assigned to the property of the class.
  * @param object $battles Battle model passed from index
 */
  function __construct($battles)
  {
    $this->battles = $battles;
  }

  /**
    * Function for outputting data from the battles in JSON format.
    *
    */
  public function battlesDataAsJSON()
  {
    $battles = $this->battles->getBattles();
    echo(json_encode($battles));
  }

  /**
    * Function for outputting battle data in JSON format
    * @param string $name Used to query battle by name
    *
    */
  public function sendBattleByNameAsJSON($name)
  {
    $battle = $this->battles->getBattleByName($name);
    echo(json_encode($battle));
  }

  /**
     * Function for outputting factions data in JSON format
     * @param integer $id Unique id used to query specific battle
     */
  public function sendFactionsByBattleIdAsJSON($id)
  {
    $factions = $this->battles->getFactionsByBattleId($id);
    echo(json_encode($factions));
  }

  /**
     * Function for outputting RSS feed of chosen battle data
     * @param integer $battleId Unique id used to query specific battle
     */
  public function renderRSSByBattleId($battleId)
  {
    $battle = $this->battles->getBattleById($battleId);
    $factions = $this->battles->getFactionsByBattleId($battleId);
    $unixtime = strtotime($battle['date']);
    $date = date("F j, Y", $unixtime);

    $rssFeed = "<?xml version='1.0' encoding='UTF-8'?>";
    $rssFeed .= "<rss version='2.0'>";
    $rssFeed .= "<channel>";
    $rssFeed .= "<title>DSA Civil Wars</title>";
    $rssFeed .= "<description>An RSS feed for civil war battles</description>";
    $rssFeed .= "<link>http://localhost:8000</link>";
    $rssFeed .= "<battle>";
    $rssFeed .= "<name>" . $battle['name'] . "</name>";
    $rssFeed .= "<location>" . $battle['location'] . "</location>";
    $rssFeed .= "<date>" . $date . "</date>";
    $rssFeed .= "<description>" . $battle['description'] . "</description>";
    $rssFeed .= "<outcome>" . $battle['outcome'] . "</outcome>";
    foreach ($factions as $faction) {
      $rssFeed .= "<faction>";
      $rssFeed .= "<name>" . $faction['factionName'] . "</name>";
      foreach($faction['notablePersons'] as $notablePerson) {
        $rssFeed .= "<notablePerson>";
        $rssFeed .= "<name>" . $notablePerson['name'] . "</name>";
        $rssFeed .= "<image>" . $notablePerson['imageURL'] . "</image>";
        $rssFeed .= "</notablePerson>";
      }
      $rssFeed .= "</faction>";
    }
    $rssFeed .= "</battle>";
    $rssFeed .= "</channel>";
    $rssFeed .= "</rss>";

    echo $rssFeed;
  }
}
