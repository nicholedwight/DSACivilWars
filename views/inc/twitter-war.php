<?php
//Based on code by James Mallison, see https://github.com/J7mbo/twitter-api-php
ini_set('display_errors', 1);
require_once('./vendor/TwitterAPIExchange.php');

/** Set access tokens here - see: https://dev.twitter.com/apps/ **/
$settings = array(
  'oauth_access_token' => "1658174634-C6uoYZsW7kbPEqHohj039CRMjVvgZKGrWJGgfYs",
  'oauth_access_token_secret' => "qfjAOsaUdTKk3lJIbnkntNe4fpnQdampC6hs2SqZESBVR",
  'consumer_key' => "cUoJtlCdfGW4rMDpnORVz6Mfu",
  'consumer_secret' => "RbNDMvbH16pRRyL2a1Q1kia5ZqegwajY3p0fsbGUYH4CoVzZnu"
);

/** Perform a GET request and echo the response **/
$url = 'https://api.twitter.com/1.1/search/tweets.json';
$getfield = '?q=%23englishcivilwar&result_type=recent';
$requestMethod = 'GET';
$twitter = new TwitterAPIExchange($settings);
$data=$twitter->setGetfield($getfield)
             ->buildOauth($url, $requestMethod)
             ->performRequest();

// Read the $data JSON into a PHP object
$phpdata = json_decode($data, true);

//Set some HTML for presentation of tweets
?> <div class="hashtag_section_wrapper cf"> <?php

//Loop through the status updates and print out the text of each
foreach ($phpdata["statuses"] as $status){
  $screen_name = $status["user"]["screen_name"];
  $name = $status["user"]["name"];
  $tweet = $status["text"];
  $time = date("H:i", strtotime($status["created_at"]));
  $profileimage = $status["user"]["profile_image_url"];
  ?>
    <div class="tweet_box">
    <div class="inner">
      <p>
        <a href="http://www.twitter.com/<?php echo $screen_name; ?>" target="_blank">
          <img src="<?php echo $profileimage; ?>" alt="<?php echo $name; ?>'s Profile Image">
          <?php echo $name; ?>
        </a>
        <span class="sub">@<?php echo $screen_name . " at " . $time; ?></span>
      </p>
      <p class="tweet"> <?php echo $tweet;?> </p>
    </div>
    </div>
<?php } ?>
</div>
