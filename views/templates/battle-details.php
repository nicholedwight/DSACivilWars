<h1 class='page-header'><?php echo $battle['name']; ?></h1>
<h3><?php echo $battle['location']; ?></h3>
<p><?php echo $battle['outcome']; ?></p>
<p><?php echo $battle['date']; ?></p>
<?php foreach($factions['factions'] as $faction):?>
  <h2><?php echo $faction['factionName'];?></h2>
  <h3><?php echo $faction['notablePerson'];?></h3>
  <?php if(isset($faction['notablePersonTwo'])): ?>
    <h3><?php echo $faction['notablePersonTwo'];?></h3>
  <?php endif; ?>
<?php endforeach; ?>