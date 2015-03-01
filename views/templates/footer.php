</div>
<footer>
  <div class="footer-nav">
    <?php foreach($battles as $battle): ?>
      <a href="battle<?php echo $battle['id'];?>" >
        <?php echo $battle['name']; ?>
      </a>
    <?php endforeach;?>
  </div>
</footer>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?v=3.exp"></script>
<script src="./node_modules/underscore/underscore.js"></script>
<script src="./node_modules/bootstrap/dist/js/bootstrap.js"></script>
<script src="./assets/js/global.js"></script>
</body>
</html>
