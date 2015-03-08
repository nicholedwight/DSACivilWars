<?php

/**
 * Comments model which contains methods for returning comment and user data
 *
 * File contains methods for querying database and returning
 * data to then be output to the page.
 */

class Comments {
  // Comment properties
  public $db;
  public $comments;

  /**
   * Magic method for assigning the database argument as a property to the battles class
   * @param object $db Database object
   */
  public function __construct($db)
  {
    $this->db = $db;
  }

  /**
   * Function for inserting Comments into the database
   * @param  string $comment Comment of the battle
   * @param  date $userid Userid of the user's Twitter account
   * @param  string $username Username of the user's Twitter account
   * @param  float $profile_image_url Profile Image of the user's Twitter account
   * @param  float $battle_id Battle id of the battle
   * @param  string $date Date of the comment
   */
    public function insertComment($comment, $userid, $username, $profile_image_url, $battle_id, $date) {

    $stmt = $this->db->query("INSERT INTO comments (comment, userid, created_at, battle_id) VALUES ('$comment', '$userid', '$date', $battle_id)");
    $stmt->execute();
  }

  /**
   * Function for inserting New Users into the database
   * @param  date $userid Userid of the user's Twitter account
   * @param  string $username Username of the user's Twitter account
   * @param  float $profile_image_url Profile Image of the user's Twitter account
   */
    public function registerNewUser($userid, $username, $profile_image_url) {
      $stmt = $this->db->query("INSERT INTO users (userid, username, profile_image_url) VALUES ('$userid', '$username', '$profile_image_url')");
      $stmt->execute();
  }

  /**
   * Function for getting all userinfo from the database based on User ID
   * by querying where the id is equal to the parameter and
   * then adding to array and returning it.
   * @param  integer $userid User ID of battle to query
   * @return array $row Returns the row containing all data for user
   */
  public function getUserInfoByID($userid) {
    $stmt = $this->db->query("SELECT * FROM users WHERE userid = $userid");
    $stmt->execute();
    if ($row = $stmt->fetch()) {
      return $row;
    } else {
      return false;
    }
  }

  /**
   * Function for getting all comments for a specific battle
   * from the database based on Battle ID
   * by querying where the id is equal to the parameter and
   * then adding to array and returning it.
   * @param  integer $battle_id ID of battle to query
   * @return array $commentRows Returns array containing all
   * comments for chosen battle
   */
  public function getAllCommentsByBattleID($battle_id) {
    $stmt = $this->db->query("SELECT *
              FROM comments
              INNER JOIN users
              ON comments.userid = users.userid
              WHERE battle_id = :id");

    $stmt->bindParam(':id', $battle_id);
    $stmt->execute();
    $rows = array();
      while($row = $stmt->fetch()) {
        $rows[] = $row;
      }
      return $rows;

  }

  /**
   * Function for setting a redirect URL within
   * a cookie. This is set on the battle-details page.
   * Its used when redirecting the user back to app
   * from Twitter Authentication.
   */
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
 * http://www.webtipblog.com/add-links-to-twitter-mentions-hashtags-and-urls-with-php-and-the-twitter-1-1-oauth-api/
 *
 * This function was modified to fit my needs,
 * the node structure was slightly different than what
 * was written in the example code. I also converted it
 * all to work with a PHP array rather than JSON
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
          'curText' => $url["url"],
          'newText' => "<a href='" .
                        $url['expanded_url'] .
                        "'>" .
                        $url["display_url"] .
                        "</a>"
        );
    }

    // add each user mention to the array
    foreach ( $tweet["entities"]["user_mentions"] as $mention ) {
      $string = $mention["screen_name"];
      $tweetEntites[] = array (
          'type'    => 'mention',
          'curText' => $string,
          'newText' => "<a href='http://twitter.com/" .
                        $mention["screen_name"] .
                        "' target='_blank'>" .
                        $string .
                        "</a>"
        );
    }

    // add each hashtag to the array
    foreach ( $tweet["entities"]["hashtags"] as $tag ) {
      $string = $tag["text"];
      $tweetEntites[] = array (
          'type'    => 'hashtag',
          'curText' => $string,
          'newText' => "<a href='http://twitter.com/search?q=%23" .
                        $tag['text'] .
                        "&src=hash' target='_blank'>" .
                        $string . "</a>"
        );
    }

    // replace the old text with the new text for each entity
    foreach ( $tweetEntites as $entity ) {
      $tweetText = str_replace( $entity['curText'], $entity['newText'], $tweetText );
      $tweetText = preg_replace('/[^(\x20-\x7F\p{Sc})]/u', '', $tweetText);
    }

    return $tweetText;

  }
}
