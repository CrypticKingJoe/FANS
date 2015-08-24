<?php
if (!isset($SETTINGS)) {
	die("Uninitialised");
}
?>
<script type="text/javascript">
	$(document).ready(function() {
		$('#mob-nav').slideUp(0);
		$('#mob-usernav').slideUp(0);
		$('#mob-nav-b').click(function() {
			$('#mob-nav').slideToggle(100);
			$('#mob-usernav').slideUp(100);
		});
		$('#mob-usernav-b').click(function() {
			$('#mob-usernav').slideToggle(100);
			$('#mob-nav').slideUp(100);
		});
		
		$(window).resize(function() {
			if ($(window).width() > 768) {
				$('#mob-nav').slideUp(0);
				$('#mob-usernav').slideUp(0);
			}
		});
		
		$('.container').css({ marginTop: '60px', opacity: 0.3 });
		$('.container').animate({ marginTop: '50px', opacity: 1 }, 500, false);
	});
</script>
<div class="usernav">
	<div class="wrapper">
		<div class="hidden-xs">
			<?php
			if ($logged) {
				foreach ($s_usernavlinks as $s_usernavlink) {
					?>
					<a href="<?php echo $s_home . $s_usernavlink[1]; ?>"><?php echo $s_usernavlink[0]; ?></a>
					<?php
				}
			}
			?>
		</div>
		<div class="pull-right">
			<?php
			if ($logged) {
				?>
				<a href="<?php echo $s_home; ?>profile/"><?php echo $user['Username']; ?></a>
				<a href="<?php echo $s_home; ?>inbox/"><i class="fa fa-comment"></i> 0</a>
				<a href="<?php echo $s_home; ?>requests/"><i class="fa fa-user-plus"></i> 0</a>
				<a href="<?php echo $s_home; ?>transactions/"><span class="money"><i class="fa fa-circle"></i> 50</span></a>
				<a href="<?php echo $s_home; ?>logout/"><i class="fa fa-sign-out"></i></a>
				<?php
			} else {
				?>
				<a href="<?php echo $s_home; ?>login/">Login</a>
				<a href="<?php echo $s_home; ?>register/">Register</a>
				<?php
			}
			?>
		</div>
	</div>
	<div id="mob-nav" class="mob-nav">
		<div class="mob-wrapper">
			<?php
			foreach ($s_navlinks as $s_navlink) {
				?>
				<a href="<?php echo $s_home . $s_navlink[1]; ?>"><?php echo $s_navlink[0]; ?></a>
				<?php
			}
			?>
		</div>
	</div>
	<div id="mob-usernav" class="mob-nav">
		<div class="mob-wrapper">
			<?php
			if ($logged) {
				foreach ($s_usernavlinks as $s_usernavlink) {
					?>
					<a href="<?php echo $s_home . $s_usernavlink[1]; ?>" class="mob-user"><?php echo $s_usernavlink[0]; ?></a>
					<?php
				}
			}
			?>
		</div>
	</div>
</div>
<div class="nav">
	<div class="wrapper">
		<a href="<?php echo $s_home; ?>" class="logoHolder">
			<img class="logo" src="<?php echo $s_home; ?>img/<?php echo $s_logo; ?>" />
		</a>
		<div class="link-group hidden-xs">
			<?php
			foreach ($s_navlinks as $s_navlink) {
				?>
				<a href="<?php echo $s_home . $s_navlink[1]; ?>" <?php if ($PAGE == $s_navlink[0]) echo 'class="active"'; ?>><?php echo $s_navlink[0]; ?></a>
				<?php
			}
			?>
		</div>
		<div class="link-group visible-xs">
			<a id="mob-nav-b"><i class="fa fa-bars"></i></a>
			<?php if ($logged) { ?><a id="mob-usernav-b"><i class="fa fa-user"></i></a><?php } ?>
		</div>
		</div>
	</div>
</div>
<?php
if (isset($SIDEBAR_LEFT)) {
	echo '<div class="sidebar-left">';
} elseif (isset($SIDEBAR_RIGHT)) {
	echo '<div class="sidebar-right">';
} else {
	echo '<div class="container">';
}

if (isset($LOCKED) && !$logged) {
	?>
	<div class="locked">
		<img src="<?php echo $s_home; ?>img/locked.png" />
		<h1>Users Only</h1>
		<p>Please <a href="<?php echo $s_home; ?>login/">login</a> to continue</p>
	</div>
	<?php
}