<?php
//Based on code by James Mallison, see https://github.com/J7mbo/twitter-api-php
ini_set('display_errors', 1);
require_once('./vendor/TwitterAPIExchange.php');
$Db = Database::getInstance();
$comments = new Comments($Db);

/** Set access tokens here - see: https://dev.twitter.com/apps/ **/
$settings = array(
  'oauth_access_token' => "1658174634-C6uoYZsW7kbPEqHohj039CRMjVvgZKGrWJGgfYs",
  'oauth_access_token_secret' => "qfjAOsaUdTKk3lJIbnkntNe4fpnQdampC6hs2SqZESBVR",
  'consumer_key' => "cUoJtlCdfGW4rMDpnORVz6Mfu",
  'consumer_secret' => "RbNDMvbH16pRRyL2a1Q1kia5ZqegwajY3p0fsbGUYH4CoVzZnu"
);

/** Perform a GET request and echo the response **/
//Setting variables for the getfield
$url = 'https://api.twitter.com/1.1/search/tweets.json';
$battleName =  str_replace(' ', '', $battle['name']);//Removing whitespace from battle name for the getfield

$getfield = "?q=#". $battleName;

//Looping through factions array to display both factions and all potential notable people in the getfield
foreach ($factions as $faction) {
      $getfield .= "+OR+#" . str_replace(' ', '', $faction['factionName']);
      foreach($faction['notablePersons'] as $notablePerson) {
        $getfield .= "+OR+#" . str_replace(' ', '', $notablePerson['name']);
      }
}
$getfield .= "+OR+English%20Civil%20War" .
            "+OR+#englishcivilwar" .
            "&count=10&result_type=recent";
// echo $getfield;

$requestMethod = 'GET';
$twitter = new TwitterAPIExchange($settings);
$data=$twitter->setGetfield($getfield)
             ->buildOauth($url, $requestMethod)
             ->performRequest();

$cacheData =  './tmp/tweet-cache/' . 'twitter-cache-' . $battle['id'] . '.txt';
if (file_exists($cacheData)) {
  $modified =filemtime($cacheData);
} else {
  $modified = false;
}
$now = time();
$interval = 600; // ten minutes

if ( !$modified || ( ( $now - $modified ) > $interval ) ) {
  //Check twitter response for errors.
  if ( isset( $data->errors[0]->code )) {
     // If errors exist, print the first error for a simple notification.
     echo "Error encountered: ".$data->errors[0]->message." Response code:" .$data->errors[0]->code;
  } else {
     // No errors exist. Write tweets to json/txt file.
     $file = "./tmp/tweet-cache/twitter-cache-" . $battle['id'] . ".txt";
     $fh = fopen($file, 'w') or die("can't open file");
     fwrite($fh, $data);
     fclose($fh);
     // 
    //  if (file_exists($file)) {
    //     echo $file . " successfully written (" .round(filesize($file)/1024)."KB)";
    //  } else {
    //      echo "Error encountered. File could not be written.";
    //  }
  }
}

$cacheData = file_get_contents('./tmp/tweet-cache/twitter-cache-' . $battle['id'] . '.txt');
$cacheData = trim($cacheData);
// Read the $data JSON into a PHP object
$phpdata = json_decode($cacheData, true);

// echo "<pre>";
// var_dump($phpdata);
//Set some HTML for presentation of tweets
?>
<div class="hashtag_section_wrapper cf">
  <h3 class="tweet-header">Tweets</h3>
<?php
//Loop through the status updates and print out the text of each
foreach ($phpdata["statuses"] as $status){

  $screen_name = $status["user"]["screen_name"];
  $name = $status["user"]["name"];
  $time = date("H:i", strtotime($status["created_at"]));
  $profileimage = $status["user"]["profile_image_url"];
  // Reformatting the text within the tweets to make links and hashtags clickable
  $tweetText = $comments->addTweetEntityLinks($status);
  $tweet = $tweetText;
  ?>
    <div class="tweet_content_wrapper">
    <img src="<?php echo $profileimage; ?>" alt="<?php echo $name; ?>'s Profile Image" class="twitter_user_image">
      <div class="comment_user_info">
        <p>
          <a href="http://www.twitter.com/<?php echo $screen_name; ?>" target="_blank">
              <strong><?php echo $name; ?></strong>
          </a>
          <span class="comment_date">@<?php echo $screen_name . " at " . $time; ?></span>
        </p>
      </div>
      <div class="tweet_content"> <?php echo $tweet;?> </div>
    </div>
<?php } ?>
</div>
