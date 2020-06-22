
<!-- ***** Main Menu Area Start ***** -->
<div class="mainMenu d-flex align-items-center justify-content-between">
  <!-- Close Icon -->
  <div class="closeIcon">
    <i class="ti-close" aria-hidden="true"></i>
  </div>
  <!-- Logo Area -->
  <div class="logo-area">
    <a href="index.php">Black Music</a>
  </div>
  <!-- Nav -->
  <div class="sonarNav wow fadeInUp" data-wow-delay="1s">
    <nav>
      <ul>
       <li class='nav-item active'>
        <a href='home.php' class='nav-link'>
          <span style='float: left; padding-right: 20px;' class='fa fa-home'></span>Home
        </a>
      </li>
      <li class='nav-item active'>
        <a href='charts.php?chart=newlyReleased&vGenre=All' class='nav-link'>
          <span style='float: left; padding-right: 20px;' class='fa fa-bandcamp'></span>Discover
        </a>
      </li>
      <li class='nav-item active'>
        <a href='mylist_video.php' class='nav-link'>
          <span style='float: left; padding-right: 20px;' class='fa fa-list'></span>My List
        </a>
      </ul>
    </nav>
  </div>
  <br>
  <!-- Copwrite Text -->
  <div class="copywrite-text">
    <p><!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
      Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | This template is made with <i class="fa fa-heart-o" aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank">Colorlib</a>
      <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
    </p>
  </div>
</div>
<!-- ***** Main Menu Area End ***** -->

<!-- ***** Header Area Start ***** -->
<header style="background-color: #232323;" class="header-area">

  <div class="row">
    <div class="col-12" style="padding: 0;">
      <div class="menu-area d-flex justify-content-between">
        <!-- Logo Area  -->
        <div class="logo-area">
          <a href="home.php">Black Music</a>
        </div>

        <!-- search bar -->
        <form action="search.php" method="GET">
          <input style='margin: 0; width: 500px; padding: 10px; border: 1px solid; border-color: #2f2f2f;' type='text' name='search' class="hidden" placeholder='Search Songs, Artists'>
        </form>

        <div class="menu-content-area d-flex align-items-center">
          <!-- Header Social Area -->
          <div class="header-social-area d-flex align-items-center">

            <!-- admin icon -->
            <?php if ($user == "@blackmusic") {
              echo "<a href='admin.php' class='fa fa-user'><i aria-hidden='true'></i></a>";
            } ?>

            <!-- shopping cart dropdown -->
            <div class="dropdown">
              <?php
                //Get cart items
              $vs_cart_quer = mysqli_query($con, "SELECT * FROM vsong_cart WHERE vs_cart_user = '$user' ORDER BY vs_cart_id ");
              $cart_count = mysqli_num_rows($vs_cart_quer);
              if ($cart_count) {
                $cart_notif = "<span style='background: red; color: white; padding: 5px 8px; position: absolute; border-radius: 50%; right: -5px; top: -12px;' class='badge hidden'>$cart_count</span>";
              } else {
                $cart_notif = "<span style='background: red; color: white; padding: 5px 8px; position: absolute; border-radius: 50%; right: -5px; top: -12px;' class='badge'></span>";
              }
              ?>
              <!-- cartFunction disabled so as to not show dropdown -->
              <a href="checkout.php" onclick="carFunction()" class="hidden dropbtn fa fa-shopping-cart"><i class="" aria-hidden="true"></i></a>
              <?php echo $cart_notif; ?>
              <div id="cartDropdown" class="dropdown-content dropdown-shopping">
                <div class='myrow'><h4>Shopping Cart</h4></div>
                <div style="max-height: 500px; overflow-y: scroll;">
                  <?php
                  while($vs_cart_fetch = mysqli_fetch_assoc($vs_cart_quer)) {
                    extract($vs_cart_fetch);
                    echo "
                    <div class='myrow'>
                    <div class='media'>
                    <div class='media-left'>
                    <a href='play_video.php?vs_cart_song=$vs_cart_song'>
                    <img width='150px' height='auto' src='img/havi logos-4.png'>
                    </a>

                    </div>
                    <div class='media-body'>
                    $vs_cart_songname
                    <br>
                    <small>$vs_cart_songartist</small>
                    <br>
                    <br>
                    <a href='cart_delete.php?vs_cart_id=$vs_cart_id' style='float: right; color: black;'><span class='fa fa-trash'></span> <small>Delete</small></a>
                    </div>
                    </div>

                    </div>
                    ";
                  }

                  if ($cart_count) {
                    echo "
                    <div class='myrow'>
                    <a href='checkout.php' style='width: 0;'><button class='mysonar-btn'>CHECKOUT</button>
                    </a>
                    </div>";
                  }
                  ?>
                </div>
              </div>
            </div>

            <!-- notification dropdown -->
            <div class="dropdown">

             <?php
                                   //Get Official messeges from Black Music
             $notif_mes = mysqli_query($con, "SELECT * FROM bm_notifies WHERE recipient = '$user'");
                                   //Get Deco notifications
             $deco_notif = mysqli_query($con, "SELECT * FROM deco_notifies WHERE dn_to = '$user'");
                                   //Get notifications if followed
             $fn_quer = mysqli_query($con, "SELECT * FROM f_notifies WHERE fn_followed = '$user'");
                                   //Get notifications if someone buys user's songs
             $vsn_quer = mysqli_query($con, "SELECT * FROM vs_notifies WHERE vsn_bought_artist = '$user'");
                                   //Add badge count
             $badge = mysqli_num_rows($fn_quer) + mysqli_num_rows($vsn_quer) + mysqli_num_rows($notif_mes) + mysqli_num_rows($deco_notif);
             if ($badge == 0) {
              $notif = "<span style='background: red; color: white; padding: 5px 8px; position: absolute; border-radius: 50%; right: -5px; top: -12px;' class='badge'></span>";
            } else {
              $notif = "<span style='background: red; color: white; padding: 5px 8px; position: absolute; border-radius: 50%; right: -5px; top: -12px;' class='badge'>$badge</span>";
            }
            ?>

            <a onclick='bellFunction()' style='position: relative;' class='dropbtn fa fa-bell' data-toggle='tooltip' data-placement='bottom'><i class=' aria-hidden='true'></i></a>
            <?php echo $notif; ?>
            <div id="bellDropdown" class="dropdown-content dropdown-notification">
              <div class='myrow'><h4>Notifications</h4></div>
              <div style="max-height: 500px; overflow-y: scroll;">
                <?php 
                while ($notif_mes_fetch = mysqli_fetch_assoc($notif_mes)) {
                  extract($notif_mes_fetch);
                  echo "<div class='myrow' style='margin: 0; padding: 0;'>
                  <a href='musicianpage.php?username=@blackmusic&bmn_id=$bmn_id' style='padding: 10px;'>
                  <h6>$message</h6>
                  </a>
                  </div>";
                }
                ?>

                <?php 
                while ($deco_fetch = mysqli_fetch_assoc($deco_notif)) {
                  extract($deco_fetch);
                  echo "
                  <div class='myrow' style='margin: 0; padding: 0;'>
                  <a href='musicianpage.php?dn_from=$dn_from' style='padding: 10px;'>
                  <p>
                  <small>$dn_from</small> 
                  <span style='color: purple;'>just Decorated </span><small>you.</small>
                  </p>
                  </a>
                  </div>";
                }
                ?>

                <?php
                if (mysqli_num_rows($fn_quer)) {
                  echo "
                  <div class='myrow'>
                  <a style='color: purple;' href='#'><h5 style='color: purple;'>New Fans</h5></a>
                  </div>
                  ";
                }
                while ($fn_fetch = mysqli_fetch_assoc($fn_quer)) {
                 extract($fn_fetch);
                 echo "
                 <div class='myrow' style='margin: 0; padding: 0;'>
                 <a href='fanpage.php?fn_follower=$fn_follower' style='padding: 10px;'><p><small>$fn_follower</small> <span style='color: purple;'>became a fan</span></p></a>
                 </div>
                 ";
               }
               ?>

               <?php
               if (mysqli_num_rows($vsn_quer)) {
                echo "
                <div class='myrow'>
                <a style='color: purple;' href='#'><h5 style='color: purple;'>Songs Bought</h5></a>
                </div>
                ";
              }
              while ($vsn_fetch = mysqli_fetch_assoc($vsn_quer)) {
               extract($vsn_fetch);
               echo "
               <div class='myrow' style='margin: 0; padding: 0;'>
               <a href='fanpage.php?vsn_buyer=$vsn_buyer' style='padding: 10px;'><p><small>$vsn_buyer</small> <span style='color: purple;'>just bought </span><small>$vsn_bought_name</small></p></a>
               </div>";
             }
             ?>
           </div>
         </div>
       </div>

       <!-- avatar dropdown -->
       <div class="dropdown">
        <a class="dropbtn" aria-hidden="true">
          <?php 
          if (!empty($user)) {
            echo "
            <img style='vertical-align: middle; width: 25px; height: 25px; border-radius: 50%;' src='$pp_path' alt='Avatar' class='dropbtn' onclick='avatarFunction()'>
            ";
          } else {
            echo "<img src='img/male_avatar.png' style='vertical-align: top; width: 30px; height: 30px; border-radius: 50%;' alt='avatar' >";
          }
          ?>
        </a>
        <div id="avatarDropdown" style="right: 1px;" class="dropdown-content">
          <div class='myrow' style="padding: 0px; margin: 0;">
            <a href="profile.php" style='padding: 10px;'>
              <h5><?php echo "$name"; ?></h5>
              <h6><?php echo $_COOKIE['username']; ?></h6>
            </a>
          </div>
          <?php if ($acc_type == "musician") {
            echo "
            <div class='myrow' style='padding: 0px; margin: 0;'>
            <a href='studio.php' style='padding: 10px;'><h6>Studio</h6></a>
            </div>
            ";
          } else {
            echo "
            <div class='myrow' style='padding: 0px; margin: 0;'>
            <a href='become_musician.php' style='padding: 10px;'><h6>Become a Musician</h6></a>
            </div>
            ";
          }
          ?>
          <div class='myrow' style="padding: 0px; margin: 0;">
            <a href="settings.php" style='padding: 10px;'><h6>Settings</h6></a>
          </div>
          <div class='myrow' style="padding: 0px; margin: 0;">
            <a href="help.php" style='padding: 10px;'><h6>Help Centre</h6></a>
          </div>
          <div class='myrow' style="padding: 0px; margin: 0;">
            <a href="index.php" style='padding: 10px;'><h6>Sign out</h6></a>
          </div>

        </div>
      </div>
    </div>
    <!-- Menu Icon -->
    <span class="navbar-toggler-icon hidden" id="menuIcon"></span>
  </div>

</div>
</div>
</div>
</header>
<!-- ***** Header Area End ***** -->