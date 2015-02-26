<div id="map-canvas"></div>
<?php foreach($battles as $battle):?>
  <div class='battleTest'>
   <h2><?php echo $battle['name']; ?></h2>
   <p><?php echo $battle['location']; ?></p>
   <span><?php echo $battle['outcome']; ?></span>
   <span><?php echo $battle['date']; ?></span>
  </div>
<?php endforeach; ?>