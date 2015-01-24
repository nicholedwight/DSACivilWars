<?php
$json = file_get_contents('./data/battles-data.json');

$jsonArray = json_decode($json, true);
?>
<pre>
  <?php
foreach($jsonArray as $jsonItem) {
  var_dump(
  $jsonItem['name'],
  $jsonItem['date'],
  $jsonItem['location'],
  $jsonItem['lat'],
  $jsonItem['lng'],
  $jsonItem['outcome']
  );
}

?>
</pre>
