
<!-- bottom nav -->
<div class="row" style="margin: 0px; padding: 0px;">
  <div class="col-sm-12" style="margin: 0px; padding: 0px;">
    <div class="bottomNav menu-content-area header-social-area">
      <div class="container-fluid menu-area d-flex justify-content-between">
        <a href="home.php" style="color: white; text-align: center; font-size: 10px; font-weight: 100;">
          <span style="font-size: 20px;" class="fa fa-home nav-link"></span>
          <br>
        Home</span></a>
        <a href="charts.php?chart=newlyReleased&vGenre=All" style="color: white; text-align: center; font-size: 10px; font-weight: 100;">
          <span style="font-size: 20px;" class="fa fa-bandcamp nav-link"></span>
          <br>
        Discover</span></a>
        <a href="search.php" style="color: white; text-align: center; font-size: 10px; font-weight: 100;">
          <span style="font-size: 20px;" class="fa fa-search nav-link"></span>
          <br>
        Search</span></a>
        <?php
                //Get cart items
        $vs_cart_quer = mysqli_query($con, "SELECT * FROM vsong_cart WHERE vs_cart_user = '$user' ORDER BY vs_cart_id ");
        $cart_count = mysqli_num_rows($vs_cart_quer);
        if ($cart_count) {
          $cart_notif = "<a href='checkout.php' style=''><span style='background: red; color: white; padding: 5px 8px; position: absolute; border-radius: 50%; right: 100px;' class='badge'>$cart_count</span></a>";
        } else {
          $cart_notif = "<span style='background: red; color: white; padding: 5px 8px; position: absolute; border-radius: 50%; right: -5px; top: -12px;' class='badge'></span>";
        }
        ?>
        <a href="checkout.php" style="color: white; text-align: center; font-size: 10px; font-weight: 100;">
          <span style="font-size: 20px;" class="fa fa-shopping-cart nav-link"></span>
          <br>
        Cart</span></a>
        <?php echo $cart_notif; ?>
        <a href="mylist_video.php" style="color: white; text-align: center; font-size: 10px; font-weight: 100;">
          <span style="font-size: 20px;" class="fa fa-list nav-link"></span>
          <br>
        My List</span></a>
      </div>
    </div>
  </div>
</div>

<!-- ***** Footer Area Start ***** -->
<footer class="footer-area">
  <!-- back end content -->
  <div class="backEnd-content">
    <img class="dots" src="img/core-img/dots.png" alt="">
  </div>

  <div class="container">
    <div class="row">
      <div class="col-sm-12">
        <!-- Copywrite Text -->
        <div class="copywrite-text">
          <p><!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
            Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | This template is made with <i class="fa fa-heart-o" aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank">Colorlib</a>
            <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
          </p>
        </div>
      </div>
    </div>
  </div>
</footer>
<!-- ***** Footer Area End ***** -->

<!-- jQuery (Necessary for All JavaScript Plugins) -->
<script src="js/jquery/jquery-2.2.4.min.js"></script>
<!-- Popper js -->
<!-- <script src="js/popper.min.js"></script> -->
<!-- Bootstrap js -->
<script src="js/bootstrap.min.js"></script>
<!-- Plugins js -->
<script src="js/plugins.js"></script>
<!-- Active js -->
<script src="js/active.js"></script>

<!-- Black Music JS -->
<script src="black_music.js"></script>
