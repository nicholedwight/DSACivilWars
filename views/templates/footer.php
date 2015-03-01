</div>
<footer>
  <div class="footer-nav">
    <ul class="footer-battles">
      <li>
        <strong>Developed with &#10084; and caffeine by:</strong>
      <li>
      <li>13000673</li>
      <li>13000673</li>
      <li>13000673</li>
      <li>13000673</li>

      <?php foreach($battles as $battle): ?>
        <li>
          <a href="battle<?php echo $battle['id'];?>" >
            <?php echo $battle['name']; ?>
          </a>
        </li>
      <?php endforeach;?>
    </ul>
  </div>
</footer>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?v=3.exp"></script>
<script src="./node_modules/underscore/underscore.js"></script>
<script src="./node_modules/bootstrap/dist/js/bootstrap.js"></script>
<script src="./assets/js/global.js"></script>
</body>
</html>
