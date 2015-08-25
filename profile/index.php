<?php
$NO_CONTAINER = true;
$TITLE = 'Profile';

require "../inc/Settings.php";
require "../inc/Head.php";

if (!isset($_GET['ID']) && !$logged) {
	header('location: ../login/');
	die();
}

$ID = 0;
$profile = null;

if (isset($_GET['ID'])) {
	$ID = addslashes($_GET['ID']);
	$profileQ = $db->prepare("SELECT * FROM `users` WHERE `ID`='$ID'");
	$profileQ->execute();
	$profile = $profileQ->fetch(PDO::FETCH_ASSOC);
	
	if ($profile == 0) {
		?>
		<h1>Oops!</h1>
		<p>A user with that ID could not be found.</p>
		<hr />
		<a onclick="window.history.go(-1);" class="btn btn-blue">Back</a>
		<?php
		if ($logged) {
			?>
			<a href="../profile/" class="btn btn-white">My Profile</a>
			<?php
		}
		die();
	}
} else {
	$ID = $user['ID'];
	$profile = $user;
}
?>
<div class="profile-banner" style="background-image: url('http://placehold.it/1000x200');">
	<div class="profile-options">
		<a href="#"><i class="fa fa-comment"></i></a>
		<a href="#"><i class="fa fa-user-plus"></i></a>
	</div>
	<img src="../api/avatar.php?ID=<?php echo $ID; ?>" />
	<div class="profile-status hidden-xs">
		Ayy lmao
	</div>
</div>
<div class="container container-fixed">
	<div class="profile-overview">
		<h1><?php echo $profile['Username']; ?></h1>
		<span><strong>Member Since:</strong> <?php echo date("jS F Y", $profile['DateUnix']); ?></span><br />
		<span><strong>Forum Posts:</strong> 43</span><br />
		<span><strong>Last Seen:</strong> <?php echo date("jS F Y", $profile['LastSeen']); ?></span><br />
	</div>
</div>
