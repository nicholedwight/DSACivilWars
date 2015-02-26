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

  //   public function insertComment() {
  //   $db = connectToDatabase();
  //   $comment = $_POST['comment'];
  //   $userid = $_SESSION['access_token']['user_id'];
  //   $username = $_SESSION['access_token']['screen_name'];
  //   $profile_image_url = $_SESSION['profile_image_url'];
  //   $battle_id = $_POST['battle_id'];
  //   $date = date('Y-m-d H:i:s', time());
  //
  //   $query = "INSERT INTO comments (comment, userid, created_at, battle_id) VALUES ('$comment', '$userid', '$date', $battle_id)";
  //   $result = mysqli_query($db, $query);
  // }
  //
  //   public function registerNewUser($userid, $username, $profile_image_url) {
  //   $db = connectToDatabase();
  //   $query = "INSERT INTO users (userid, username, profile_image_url) VALUES ('$userid', '$username', '$profile_image_url')";
  //   $result = mysqli_query($db, $query);
  // }
  //
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
}
