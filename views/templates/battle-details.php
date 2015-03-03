<?php
$unixtime = strtotime($battle['date']);
$date = date("F j, Y", $unixtime);
?>
<a href="./map"><button class='btn btn-primary'>< Back To Homepage</button></a>
<h1 class='page-header centered-text'><?php echo $battle['name']; ?></h1>
<div class="row">
  <div class="col-md-6 details-heading">
    <h2><?php echo $battle['location']; ?></h2>
    <p><?php echo $battle['outcome']; ?></p>
    <p><?php echo $date; ?></p>
    <!-- nl2br() preserves line breaks in text echoed from DB-->
    <p><?php echo nl2br($battle['description']);?></p>
  </div>

  <div class="col-md-6">
    <h2 class='details-heading centered-text'>Belligerents</h2>

    <?php foreach($factions as $faction):?>
      <h3 class="centered-text faction"><?php echo $faction['factionName'];?></h3>
      <div class="persons-wrapper centered-text">
        <?php foreach($faction['notablePersons'] as $notablePerson):?>
          <div class="persons-details">
            <p><?php echo $notablePerson['name'];?></p>
            <img src="<?php echo $notablePerson['imageURL'];?>" class="person-image">
          </div>
        <?php endforeach; ?>
      </div>
    <?php endforeach; ?>
  </div>
</div>
<h2 class='page-header centered-text'>What others are saying</h2>
<section class="twitter-wrapper">
  <!--Nichole's individual part, including the two files containing twitter sections-->
  <?php include('./views/inc/comment_form.php'); ?>
  <?php include('./views/inc/twitter-war.php'); ?>
</section>

<?php include('./views/inc/test.php'); ?>
