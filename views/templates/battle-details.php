<div class='wrapper'>
<?php
$unixtime = strtotime($battle['date']);
$date = date("F j, Y", $unixtime);
?>

<a href="./map"><button class='btn btn-primary'>< Back To Homepage</button></a>
<h1 class='page-header'><?php echo $battle['name']; ?></h1>
<h3><?php echo $battle['location']; ?></h3>
<p><?php echo $battle['outcome']; ?></p>
<p><?php echo $date; ?></p>
<!-- nl2br() preserves line breaks in text echoed from DB-->
<p><?php echo nl2br($battle['description']);?></p>

<?php foreach($factions['factions'] as $faction):?>
  <h2><?php echo $faction['factionName'];?></h2>
  <h3><?php echo $faction['notablePerson'];?></h3>
  <img src="<?php echo $faction['personOneImage'];?>" class="person-image">
  <?php if(isset($faction['notablePersonTwo'])): ?>
    <h3><?php echo $faction['notablePersonTwo'];?></h3>
    <img src="<?php echo $faction['personTwoImage'];?>" class="person-image">
  <?php endif; ?>
<?php endforeach; ?>

<section class="twitter-wrapper">
  <!--Nichole's individual part, including the two files containing twitter sections-->
  <?php include('./views/inc/comment_form.php'); ?>
  <?php include('./views/inc/twitter-war.php'); ?>
</section>
