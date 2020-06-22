<?php
$user = $_COOKIE['username'];
if (empty($user)) {
	header('location: index.php');
}

//DB connection for all account info
include('variables.php');
$quer = mysqli_query($con, "SELECT * FROM users WHERE username = '$user'");
$row = mysqli_fetch_assoc($quer);
extract($row);
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="description" content="">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<!-- The above 4 meta tags *must* come first in the head; any other head content must come *after* these tags -->

	<!-- Title  -->
	<title>Black Campus</title>

	<!-- Favicon  -->
	<link rel="icon" href="img/havi logos-4.png">

	<!-- Style CSS -->
	<link rel="stylesheet" href="style.css">
	<link rel="stylesheet" href="black_music.css">

	<!-- black music JS -->
	<script src="black_music.js"></script>
</head>
<body>

	<!-- Top Nav linked -->
	<?php include('topnav.php'); ?>


    <!-- Modal for Deactivating Account -->
    <div id="vidShareModal" class="modal fade" role="dialog">
      <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Copy link</h4>
            <button type="button" style="float: right;" class="close" data-dismiss="modal">&times;</button>
          </div>
          <div class="modal-body">
            <center> 
              <h6>https://music.black.co.ke/play_video.php?referrer=<?php echo $user; ?></h6>
              </center>
          </div>
          <div class="modal-footer">
          </div>
        </div>

      </div>
    </div>

	<div class="row">
		<div style="text-align: center;" class="col-sm-12">
			<br>
			<br>
			<br class="hidden">
			<br class="hidden">
			<h1>INVITES</h1>
			<h5>Invite your friends to Black Music and <i style="color: green;">earn!</i></h5>
			<br>
			<h2>How it works</h2>
			<h5>When your invites buy songs, you earn. When their friends invite others, you also earn. this goes on upto the fourth level.
				<br>Let's say you invite John, you get <i style="color: green">KES 1</i> for every song he buys. This is 
				<b>LEVEL 1</b>.
				<br>When John invites Lucy, you earn <i style="color: green">KES 0.50</i> for every song she buys. This is <b>LEVEL 2</b>.
				<br>When Lucy invites Kevin, you earn <i style="color: green">KES 0.25</i> for every song he buys. this is <b>LEVEL 3</b>.
				<br>Finaly, When Kevin invites Grace, you earn <i style="color: green">KES 0.125</i> for every song she buys. this is <b>LEVEL 4</b>.
				<br>You will be paid <b>WEEKLY</b> via <i style="color: green">MPESA</i> to the Safaricom number on your account.
				<br>Minimum withdrawal amount <i style="color: green">KES 10</i>
			</h5>
			<br>
			<h2>Why Black Music is doing this</h2>
			<h5>Black Music desires to change how people think about music and to help local artists earn from their songs.
				<br>To achieve this goal, we need your help to expand and that's why we're willing to give you a cut off of our profits.
				<br>The money we pay you comes from the songs we sell from our site.
			</h5>
			<br>
			<a href='whatsapp://send?text=https://music.black.co.ke/signup.php?referrer=<?php echo $user; ?>' data-action='share/whatsapp/share'><button class="btn sonar-btn anti-hidden">invite now</button></a>
			<button type="button" class="sonar-btn hidden" data-toggle="modal" data-target="#vidShareModal">invite now</button>
			<br>
			<br>
			<br>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-2"></div>
		<div class="col-sm-8">
			<h1 style="text-align: center;">Your invites</h1>
			<table class="table table-responsive table-hover">
				<tr>
					<th><span style='color: dodgerblue; margin-right: 20px; font-size: 15px;'>Level</span></th> 
					<th>Username</th>
					<th><small style='margin-left: 20px;'>Songs</small></th>
					<th><small style='color: green; margin-left: 20px;'>Revenue</small></th>
				</h4>
			</tr>
			<?php
			$oneTotal = $twoTotal = $threeTotal = $fourTotal = 0;
			$inviteQuer = mysqli_query($con, "SELECT * FROM referrals WHERE referrer = '$user' ");
			while ($inviteFetch = mysqli_fetch_assoc($inviteQuer)) {
				extract($inviteFetch);
				$vsongQuer = mysqli_query($con, "SELECT * FROM vsongs_bought WHERE vsong_buyer = '$referee' ");
				$vsongFetch = mysqli_fetch_assoc($vsongQuer);
				$vsongsTotal = mysqli_num_rows($vsongQuer);
				$oneRevenue = $vsongsTotal*1;
				$oneTotal += $oneRevenue;
				echo "
				<tr>
				<td><h5 style='color: dodgerblue; font-size: 15px;'>Level-1</h5></td> 
				<td><h5>$referee</h5></td> 
				<td><small>$vsongsTotal</small></td> 
				<td><h5 style='color: green;'>KES $oneRevenue</h5></td>		
				</tr>";
				$twoQuer = mysqli_query($con, "SELECT * FROM referrals WHERE referrer = '$referee' ");
				while ($twoFetch = mysqli_fetch_assoc($twoQuer)) {
					extract($twoFetch);
					$vsongQuer = mysqli_query($con, "SELECT * FROM vsongs_bought WHERE vsong_buyer = '$referee' ");
					$vsongFetch = mysqli_fetch_assoc($vsongQuer);
					$vsongsTotal = mysqli_num_rows($vsongQuer);
					$twoRevenue = $vsongsTotal*0.5;
					$twoTotal += $twoRevenue;
					echo "
					<tr>
					<td><h5 style='margin-left: 20px; color: dodgerblue; margin-right: 20px; font-size: 15px;'>Level-2</h5> 
					<td><h5 style='margin-left: 20px;'>$referee</h5></td> 
					<td><small style='margin-left: 20px;'>$vsongsTotal</small></td> 
					<td><h5 style='color: green; margin-left: 20px;'>KES $twoRevenue<h5></td>
					</tr>";
					$threeQuer = mysqli_query($con, "SELECT * FROM referrals WHERE referrer = '$referee' ");
					while ($threeFetch = mysqli_fetch_assoc($threeQuer)) {
						extract($threeFetch);
						$vsongQuer = mysqli_query($con, "SELECT * FROM vsongs_bought WHERE vsong_buyer = '$referee' ");
						$vsongFetch = mysqli_fetch_assoc($vsongQuer);
						$vsongsTotal = mysqli_num_rows($vsongQuer);
						$threeRevenue = $vsongsTotal*0.25;
						$threeTotal += $threeRevenue;
						echo "
						<tr>
						<td><h5 style='margin-left: 40px; color: dodgerblue; margin-right: 20px; font-size: 15px;'>Level-3</h5> 
						<td><h5 style='margin-left: 40px;'>$referee</h5></td> 
						<td><small style='margin-left: 40px;'>$vsongsTotal</small></td> 
						<td><h5 style='color: green; margin-left: 40px;'>KES $threeRevenue</h5></td>
						</tr>";
						$fourQuer = mysqli_query($con, "SELECT * FROM referrals WHERE referrer = '$referee' ");
						while ($fourFetch = mysqli_fetch_assoc($fourQuer)) {
							extract($fourFetch);
							$vsongQuer = mysqli_query($con, "SELECT * FROM vsongs_bought WHERE vsong_buyer = '$referee' ");
							$vsongFetch = mysqli_fetch_assoc($vsongQuer);
							$vsongsTotal = mysqli_num_rows($vsongQuer);
							$fourRevenue = $vsongsTotal*0.125;
							$fourTotal += $fourRevenue;
							echo "
							<tr>
							<td><h5 style='margin-left: 60px; color: dodgerblue; margin-right: 20px; font-size: 15px;'>Level-4</h5> 
							<td><h5 style='margin-left: 60px;'>$referee</h5></td> 
							<td><small style='margin-left: 60px;'>$vsongsTotal</small></td> 
							<td><h5 style='color: green; margin-left: 60px;'>KES $fourRevenue</h5></td>
							</tr>";
						}
					}
				}
			}
			?>
		</table>
		<br>
		<br>
		<h2>Total Revenues</h2>
		<table class="table table-responsive table-hover">
			<tr>
				<th><h5 style="color: dodgerblue;">LEVEL-1</h5></th>
				<th><h5 style="color: dodgerblue;">LEVEL-2</h5></th>
				<th><h5 style="color: dodgerblue;">LEVEL-3</h5></th>
				<th><h5 style="color: dodgerblue;">LEVEL-4</h5></th>
				<th><h5 style="color: green;">Total</h5></th>
			</tr>
			<tr>
				<?php
				$totalRevenue = $oneTotal + $twoTotal + $threeTotal + $fourTotal;
				echo "
				<td><h6 style='color: green;'>KES $oneTotal</h6></td>
				<td><h6 style='color: green;'>KES $twoTotal</h6></td>
				<td><h6 style='color: green;'>KES $threeTotal</h6></td>
				<td><h6 style='color: green;'>KES $fourTotal</h6></td>
				<td><h6 style='color: green;'>KES $totalRevenue</h6></td>
				";
				?>
			</tr>
		</table>
	</div>
	<div class="col-sm-2"></div>
</div>

<!-- Footer linked -->
<?php include('footer.php'); ?>

</body>
</html>