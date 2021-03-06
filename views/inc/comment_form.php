<?php
//Instantiating the Comments Model in order to call the insertComment function
$Db = Database::getInstance();
$comments = new Comments($Db);

//Calling a function to set a cookie to use as a redirect URL after Twitter authorisation
$comments->setRedirectCookie();

//If the user has filled out a comment, submitting the comment to the db
if(isset($_POST['comment'])){
  $comment = $_POST['comment'];
  $userid = $_SESSION['access_token']['user_id'];
  $username = $_SESSION['access_token']['screen_name'];
  $profile_image_url = $_SESSION['profile_image_url'];
  $battle_id = $_POST['battle_id'];
  $date = date('Y-m-d H:i:s', time());
  $comments->insertComment($comment, $userid, $username, $profile_image_url, $battle_id, $date);
}

//Assigning the commentRows variable to the value returned from the get comments function in the comments model
$commentRows = $comments->getAllCommentsByBattleID($id);


if ($_SESSION) {
  ?><a href='http://civilwar.dev:8888/logout.php'>Logout</a><?php
} ?>

<div class="comment_section_wrapper cf">
  <ul class="comment_list">

  <div class="comment_count">
    <!--Text changes depending on how many comments, if any are being displayed-->
    <h3><?php echo count($commentRows);
        if (count($commentRows) == 1) {
          echo " Comment";
        } else {
          echo " Comments";
        } ?>
    </h3>
  </div>


  <?php
  if ($commentRows) { //If there any comments for this page, loop through and display them
    foreach ($commentRows as $comment) {
      $date = date('F j, Y, g:i a', strtotime($comment['created_at'])); ?>
        <li>
          <img src="<?php echo $comment['profile_image_url'];?>" alt="" class="comment_avatar">
          <!--Empty alt tag because it provides no important info for users via screenreader-->
          <div class="comment_content_wrapper">
             <div class="comment_user_info">
               <p>
                 <strong>
                   <a href="http://www.twitter.com/<?=$comment['username']?>">
                   <?php echo "@" . $comment['username'];?>
                   </a>
                  </strong>
                 <span class="comment_date"><?php echo $date;?></span>
               </p>
             </div>
             <div class="comment_content">
               <?php echo $comment['comment'];?>
             </div>
          </div>
        </li>
    <?php
    }
    echo '</ul>';
  } else {
    echo "<p>No comments have been left yet!</p>";
  }
  ?>

  <div class="form_wrapper">
    <?php
    //If a user is signed in already, they can comment, otherwise a button linking to the twitter authorisation is displayed
    if (!$_SESSION) {
      echo "<a href='redirect.php' class='btn'>
              <img src='../assets/img/sign-in-with-twitter-link.png'
                alt='Sign in with Twitter to comment'>
            </a>";
    } else { ?>
      <form method="POST" action="" class="comment_form">
        <textarea name="comment" id="comment" rows="6" cols="40" class="comment_field" placeholder="Comment:" required></textarea>
        <input type="hidden" value="<?php echo $_GET['id'];?>" name="battle_id">
        <button class="submit btn btn-embossed" type="submit">Submit</button>
      </form>

      <div class="current_user_wrapper">
        <p class="current_user_name">
        <img src="<?php echo $_SESSION['profile_image_url'];?>" alt="" class="current_user_avatar">
          @<?php echo $_SESSION['access_token']['screen_name'];?>
        </p>
      </div>
      <?php
    }
    ?>
  </div>
</div>
