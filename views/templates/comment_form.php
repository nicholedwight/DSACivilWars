<?php


//set a cookie to the value of current URL
  $cookie_name = "redirectURL";

  if ($_SERVER["SERVER_PORT"] != "80") {
    $cookie_value =
    $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
  } else {
    $cookie_value = $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
  }
  setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/"); // expires in 30 days

//Submitting the comment to the db
if($_POST['comment']){
  $comment = $_POST['comment'];
  $userid = $_SESSION['access_token']['user_id'];
  $username = $_SESSION['access_token']['screen_name'];
  $profile_image_url = $_SESSION['profile_image_url'];
  $battle_id = $_POST['battle_id'];
  $date = date('Y-m-d H:i:s', time());
  $comments->insertComment($comment, $userid, $username, $profile_image_url, $battle_id, $date);
}

if ($_SESSION) {
  ?><a href='http://civilwar.dev:8888/logout.php'>Logout</a><?php
}
?>
<section class="comment_section_wrapper cf">
  <ul class="comment_list">

  <div class="comment_count">
    <h3><?php echo count($commentRows);
        if (count($commentRows) == 1) {
          echo " Comment";
        } else {
          echo " Comments";
        } ?>
    </h3>
  </div>
  <?php
  if ($commentRows) { //If there any comments for this page, display them
    foreach ($commentRows as $comment) {
      $date = date('F j, Y, g:i a', strtotime($comment['created_at'])); ?>
        <li>
          <img src="<?php echo $comment['profile_image_url'];?>" alt="" class="comment_avatar">
          <!--Empty alt tag because it provides no important info for users via screenreader-->
          <div class="comment_content_wrapper">
             <div class="comment_user_info">
               <p>
                 <strong><?php echo $comment['username'];?></strong>
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
    if (!$_SESSION) {
      echo "<a href='redirect.php'>
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
</section>
