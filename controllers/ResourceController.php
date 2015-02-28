<?php

namespace Controller;

//BlogController requires BaseController to render views
require_once 'BaseController.php';

class Resource extends Base
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

  public function sendBattleByNameAsJSON($name)
  {
    $battle = $this->battles->getBattleByName($name);
    echo(json_encode($battle));
  }

  public function sendFactionsByBattleIdAsJSON($id)
  {
    $factions = $this->battles->getFactionsByBattleId($id);
    echo(json_encode($factions));
  }


  public function renderRSSByBattleId($battleId)
  {
    $battle = $this->battles->getBattleById($battleId);
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
    $rssFeed .= "<description>" . $battle['description'] . "</description>";
    $rssFeed .= "</battle>";
    $rssFeed .= "</channel>";
    $rssFeed .= "</rss>";

    echo $rssFeed;
  }
}
