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
<script>
	$(document).ready(function() {
		function removeActive() {
			if ($('#tab-wall').hasClass('tab-active'))
				$('#tab-wall').removeClass('tab-active');
			
			if ($('#tab-about').hasClass('tab-active'))
				$('#tab-about').removeClass('tab-active');
			
			if ($('#tab-inventory').hasClass('tab-active'))
				$('#tab-inventory').removeClass('tab-active');
			
			if ($('#tab-friends').hasClass('tab-active'))
				$('#tab-friends').removeClass('tab-active');
		}
		
		function hideTabs() {
			$('#tab-content-wall').fadeOut(0);
			$('#tab-content-about').fadeOut(0);
			$('#tab-content-inventory').fadeOut(0);
			$('#tab-content-friends').fadeOut(0);
		}
		
		hideTabs();
		$('#tab-content-wall').fadeIn(0);
		
		$('#tab-wall').click(function() {
			removeActive();
			hideTabs();
			
			$('#tab-wall').addClass('tab-active');
			$('#tab-content-wall').fadeIn(200);
		});
		
		$('#tab-about').click(function() {
			removeActive();
			hideTabs();
			
			$('#tab-about').addClass('tab-active');
			$('#tab-content-about').fadeIn(200);
		});
		
		$('#tab-inventory').click(function() {
			removeActive();
			hideTabs();
			
			$('#tab-inventory').addClass('tab-active');
			$('#tab-content-inventory').fadeIn(200);
		});
		
		$('#tab-friends').click(function() {
			removeActive();
			hideTabs();
			
			$('#tab-friends').addClass('tab-active');
			$('#tab-content-friends').fadeIn(200);
		});
		
		<?php
		if ($s_profile_wall_chars > 0) {
			?>
			var charsRemaining = <?php echo $s_profile_wall_chars; ?>;
			$('#wall-comment').keyup(function() {
				if ($('#wall-comment').val().length >= <?php echo $s_profile_wall_chars; ?>) {
					$('#wall-comment').val($('#wall-comment').val().substr(0, <?php echo $s_profile_wall_chars; ?>));
				}

				charsRemaining = <?php echo $s_profile_wall_chars; ?> - ($('#wall-comment').val().length);
				$('#wall-chars-remaining').html(charsRemaining + ' characters remaining');
			});
			<?php
		}
		?>
		
		function updateWall() {
			
			$.get(
				'wall.php',
				{ 'ID': <?php echo $ID; ?>, 'get': '1' }
			).done(function(data) {
				var comments = data.split('<br />');
				$('#comments-all').html('');

				for (var i = 0; i < comments.length - 1; i++) {
					var commentData = comments[i].split(':');

					var tDate = commentData[0];
					var tUserID = commentData[1];
					var tUserName = commentData[2];
					var tComment = '';
					
					if (commentData.length == 4)
						var tComment = String(commentData[3]).replace(new RegExp("<nl></nl>", "g"), "<br />");
					else {
						for (var z = 3; z < commentData.length; z++) {	
							tComment += String(commentData[z]).replace(new RegExp("<nl></nl>", "g"), "<br />") + ":";
						}
					}
					
					$('#comments-all').append("<div class='comment'><div class='comment-left'><a href='../profile/?ID=" + tUserID + "'><div class='avatar-portrait'><img src='../api/avatar.php?ID=" + tUserID + "' /></div>" + tUserName + "</a></div><div class='comment-right'><small>Posted <strong>" + tDate + "</strong></small><hr />" + tComment + "</div></div>");
				}
			});
		}
		
		updateWall();
		
		$('#wall-form').submit(function(event) {
			event.preventDefault();
			var comment = $('#wall-comment').val();
			
			$.post(
				'wall.php?ID=<?php echo $ID; ?>',
				{ 'wall-comment': comment }
			).done(function(result) {
				if (result == '1') {
					$('#wall-comment').val('');
					updateWall();
				}
			});
		});
		
		$('#about-me-div').fadeOut(0);
		$('#about-me-edit').click(function() {
			$('#about-me-edit').fadeOut(0);
			$('#about-me-all').fadeOut(0);
			$('#about-me-div').fadeIn(200);
		});
		
		$('#cancel-about-me').click(function() {
			$('#about-me-div').fadeOut(0);
			$('#about-me-edit').fadeIn(200);
			$('#about-me-all').fadeIn(200);
		});
		
		$('#about-me-success').hide();
		$('#about-me-error').hide();
		$('#submit-about-me').click(function() {
			var about = $('#about-me').val();

			$.post(
				'about-me.php',
				{
					'ID': <?php echo $ID; ?>,
					'About': about
				}
			).done(function(result) {
				console.log(result);
				if (result == "0") {
					$('#about-me-success').hide();
					$('#about-me-error').show();
				} else {
					$('#about-me-error').hide();
					$('#about-me-success').show();
					$('#about-me-div').fadeOut(0);
					$('#about-me-all').html(result.replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, '$1<br />$2'));
					$('#about-me-all').fadeIn(200);
					$('#about-me-edit').fadeIn(200);
				}
			});
		});
	});
</script>
<div class="profile-banner" style="background-image: url('http://placehold.it/1000x200');">
	<div class="profile-options">
		<a href="#"><i class="fa fa-comment"></i></a>
		<a href="#"><i class="fa fa-user-plus"></i></a>
	</div>
	<img src="../api/avatar.php?ID=<?php echo $ID; ?>" />
</div>
<div class="container container-fixed">
	<div class="profile-overview">
		<h1><?php echo $profile['Username']; ?></h1>
		<span><strong>Member Since:</strong> <?php echo date("jS F Y", $profile['DateUnix']); ?></span><br />
		<span><strong>Forum Posts:</strong> 43</span><br />
		<span><strong>Last Seen:</strong> <?php echo date("jS F Y", $profile['LastSeen']); ?></span><br />
	</div>
	<div class="tab-holder">
		<div class="tabs">
			<div class="tab tab-active" id="tab-wall">
				Wall
			</div>
			<div class="tab" id="tab-about">
				About
			</div>
			<div class="tab" id="tab-inventory">
				Inventory
			</div>
			<div class="tab" id="tab-friends">
				Friends
			</div>
		</div>
		<div class="tab-content">
			<div id="tab-content-wall">
				<?php
				if ($logged) {
					?>
					<span style="font-size: 18px;">Write on <?php echo $profile['Username']; ?>'s wall</span><br /><br />
					<form action="" method="post" id="wall-form">
						<textarea class="input" id="wall-comment" name="wall-comment" rows="4"></textarea>
						<?php
						if ($s_profile_wall_chars > 0) {
							?>
							<small id="wall-chars-remaining" style="float: right;">200 characters remaining</small>
							<?php
						}
						?><br />
						<button type="submit" class="btn btn-blue" name="post-comment" id="post-comment">Post</button>
					</form><br /><br />
					<?php
				}
				?>
				<div id="comments-all">
				</div>
			</div>
			<div id="tab-content-about">
				<?php
				if ($logged && $ID == $user['ID']) {
					?>
					<div class="error" id="about-me-error">
						<i class="fa fa-times"></i>
						An error occurred when trying to save, please try again later
					</div>
					<div class="success" id="about-me-success">
						<i class="fa fa-check"></i>
						Your "about me" has been saved
					</div>
					<div id="about-me-div">
						<textarea name="about-me" id="about-me" class="input" rows="4" cols="10"><?php echo stripslashes(strip_tags($profile['About'])); ?></textarea><br /><br />
						<a id="submit-about-me" class="btn btn-blue">Save Changes</a>
						<a id="cancel-about-me" class="btn btn-white">Cancel</a>
					</div>
					<div id="about-me-all"><?php echo nl2br(stripslashes(strip_tags($profile['About']))); ?></div>
					<br />
					<a id="about-me-edit" class="btn btn-blue">Edit</a>
					<?php
				} else {
					echo nl2br(stripslashes(strip_tags($profile['About'])));
				}
				?>
			</div>
			<div id="tab-content-inventory">
				<?php
				if ($logged && $ID == $user['ID']) {
					?>
					You don't have anything in your inventory.
					<br /><br />
					<a href="../store/" class="btn btn-blue">Shop</a>
					<?php
				} else
					echo 'This user has nothing in their inventory.';
				?>
			</div>
			<div id="tab-content-friends">
				<?php
				if ($logged && $ID == $user['ID']) {
					?>
					You have no friends.
					<br /><br />
					<a href="../members/" class="btn btn-blue">Find People</a>
					<?php
				} else
					echo 'This user has no friends.';
				?>
			</div>
		</div>
	</div>
</div>
