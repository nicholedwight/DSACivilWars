<?php
//Based on code by James Mallison, see https://github.com/J7mbo/twitter-api-php
ini_set('display_errors', 1);
require_once('./vendor/TwitterAPIExchange.php');
// $badwords = array();
// include('banbuilder-library/lang/en-us.wordlist-regex.php');
// include('banbuilder-library/lang/en-uk.wordlist-regex.php');
// include('banbuilder-library/censor.function.php');


// header('Content-Type: text/html; charset="UTF-8"');

/** Set access tokens here - see: https://dev.twitter.com/apps/ **/
$settings = array(
  'oauth_access_token' => "1658174634-C6uoYZsW7kbPEqHohj039CRMjVvgZKGrWJGgfYs",
  'oauth_access_token_secret' => "qfjAOsaUdTKk3lJIbnkntNe4fpnQdampC6hs2SqZESBVR",
  'consumer_key' => "cUoJtlCdfGW4rMDpnORVz6Mfu",
  'consumer_secret' => "RbNDMvbH16pRRyL2a1Q1kia5ZqegwajY3p0fsbGUYH4CoVzZnu"
);

/** Perform a GET request and echo the response **/
/** Note: Set the GET field BEFORE calling buildOauth(); **/
$url = 'https://api.twitter.com/1.1/search/tweets.json';
$getfield = '?q=%23TheDress';
// $getfield = '?q=&geocode=51.502,-2.578,15km';
$requestMethod = 'GET';
$twitter = new TwitterAPIExchange($settings);
$data=$twitter->setGetfield($getfield)
           ->buildOauth($url, $requestMethod)
           ->performRequest();

//Use this to look at the raw JSON
// echo($data);

// Read the JSON into a PHP object
$phpdata = json_decode($data, true);

// Debug - check the PHP object
?>
<pre>
<?php
// var_dump($phpdata["statuses"]);
?>
</pre>
<main role="main" class="content_wrapper">
<?php
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
<?php
}
?>
<div class="proof">
<p>Proof that this is working, you can see my tweet in the screenshot below (Nichole Dwight)</p>
<img src="img/proof.jpg" alt="Proof it works" width="700px">
</div>
</main>
