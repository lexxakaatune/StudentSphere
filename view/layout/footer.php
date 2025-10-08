<footer class="footer">
  <ul class="footer__ul none">
    <li class="footer__li">
      <h3 class="footer__h3">StudentSphere</h3>
      <i class="fa-brands fa-facebook"></i>
      <p>Lorem ipsum dolor sit amet consectetur Lorem ipsum dolor sit amet Lorem ipsum dolor sit amet consectetur</p>
      <p class="footer__p">
        <a class="none social-icon" href="#">
          <i class="fa-brands fa-facebook" style="color: #74C0FC;"></i>
        </a>
        <a class="none social-icon" href="#">
          <i class="fa-brands fa-youtube" style="color: #74C0FC;"></i>
        </a>
        <a class="none social-icon" href="#">
          <i class="fa-brands fa-github" style="color: #74C0FC;"></i>
        </a>
        <a class="none social-icon" href="#">
          <i class="fa-brands fa-discord" style="color: #74C0FC;"></i>
        </a> 
      </p> 
    </li>

    <li class="footer__li">
      <ul class="none">
        <li>
          <strong>Our Phone</strong>
          <small>(+1) 654 - 5673 73</small>
        </li>
        <li>
          <strong>Our Email</strong>
          <small>example@gmail.com</small>
        </li>
        <li>
          <strong>Our Address</strong>
          <small>Q4HP+QP New York, USA</small>
        </li>
      </ul>
            
      <?php if (isset($_SESSION['flash']['user-id'])) { ?>
        <nav class="footer__nav">
          <a href="#">Home</a>
          <a href="#">About</a>
          <a href="#">Blogs</a>
          <a href="#">Contact</a>
        </nav>
      <?php } ?>
    </li>
  </ul>
  
  <?php $year = date('Y') ?>
  <p class="footer__p copyright__P">
    <small class="copyright center">
      &copy; <?=$year?> All Rights Reserved by site
    </small>
    <small class="pt center">
      <a href="#">Privacy Policy</a>
      <a href="#">Terms &amp; Conditions</a>
    </small>
  </p>
</footer>
</body>
</html>