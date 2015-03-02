<?php

class Comments {
  // Battle properties
  public $db;
  public $comments;

  // Assign parameter to argument to $db property
  public function __construct($db)
  {
    $this->db = $db;
  }

  /**
   * Queries for all data in battles table
   * @return [array]
   */

    public function insertComment($comment, $userid, $username, $profile_image_url, $battle_id, $date) {


    $stmt = $this->db->query("INSERT INTO comments (comment, userid, created_at, battle_id) VALUES ('$comment', '$userid', '$date', $battle_id)");
    $stmt->execute();
  }

    public function registerNewUser($userid, $username, $profile_image_url) {
      $stmt = $this->db->query("INSERT INTO users (userid, username, profile_image_url) VALUES ('$userid', '$username', '$profile_image_url')");
      $stmt->execute();
  }

  public function getUserInfoByID($userid) {
    $stmt = $this->db->query("SELECT * FROM users WHERE userid = $userid");
    $stmt->execute();
    if ($row = $stmt->fetch()) {
      return $row;
    } else {
      return false;
    }
  }

  public function getAllCommentsByBattleID($battle_id) {
    $stmt = $this->db->query("SELECT *
              FROM comments
              INNER JOIN users
              ON comments.userid = users.userid
              WHERE battle_id = $battle_id");

    $stmt->bindParam(':id', $battle_id);
    $stmt->execute();
    $rows = array();
      while($row = $stmt->fetch()) {
        $rows[] = $row;
      }
      return $rows;

  }

  public function setRedirectCookie() {
      $cookie_name = "redirectURL";
      //sets a cookie to the value of current URL
      if ($_SERVER["SERVER_PORT"] != "80") {
        $cookie_value = $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
      } else {
        $cookie_value = $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
      }

      setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/"); // expires in 30 days
  }

  /**
 * addTweetEntityLinks
 *
 * adds a link around any entities in a twitter feed
 * twitter entities include urls, user mentions, and hashtags
 *
 * @author     Joe Sexton <joe@webtipblog.com>
 * @param      object $tweet a JSON tweet object v1.1 API
 * @return     string tweet
 */
  public function addTweetEntityLinks($tweet) {
    // actual tweet as a string
    $tweetText = $tweet["text"];

    // create an array to hold urls
    $tweetEntites = array();

    // add each url to the array
    foreach( $tweet["entities"]["urls"] as $url ) {
      $tweetEntites[] = array (
          'type'    => 'url',
          'curText' => substr( $tweetText, $url["indices"][0], ( $url["indices"][1] - $url["indices"][0] ) ),
          'newText' => "<a href='".$url["expanded_url"]."' target='_blank'>".$url["display_url"]."</a>"
        );
    }  // end foreach

    // add each user mention to the array
    foreach ( $tweet["entities"]["user_mentions"] as $mention ) {
      $string = substr( $tweetText, $mention["indices"][0], ( $mention["indices"][1] - $mention["indices"][0] ) );
      $tweetEntites[] = array (
          'type'    => 'mention',
          'curText' => substr( $tweetText, $mention["indices"][0], ( $mention["indices"][1] - $mention["indices"][0] ) ),
          'newText' => "<a href='http://twitter.com/".$mention["screen_name"]."' target='_blank'>".$string."</a>"
        );
    }  // end foreach

    // add each hashtag to the array
    foreach ( $tweet["entities"]["hashtags"] as $tag ) {
      $string = substr( $tweetText, $tag["indices"][0], ( $tag["indices"][1] - $tag["indices"][0] ) );
      $tweetEntites[] = array (
          'type'    => 'hashtag',
          'curText' => substr( $tweetText, $tag["indices"][0], ( $tag["indices"][1] - $tag["indices"][0] ) ),
          'newText' => "<a href='http://twitter.com/search?q=%23".$tag->text."&src=hash' target='_blank'>".$string."</a>"
        );
    }  // end foreach

    // replace the old text with the new text for each entity
    foreach ( $tweetEntites as $entity ) {
      $tweetText = str_replace( $entity['curText'], $entity['newText'], $tweetText );
    } // end foreach

    return $tweetText;

  }
}
