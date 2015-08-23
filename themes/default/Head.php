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
	});
</script>
<div class="usernav">
	<div class="wrapper">
		<div class="hidden-xs">
			<?php
			foreach ($s_usernavlinks as $s_usernavlink) {
				?>
				<a href="<?php echo $s_home . $s_usernavlink[1]; ?>"><?php echo $s_usernavlink[0]; ?></a>
				<?php
			}
			?>
		</div>
		<div class="pull-right">
			<a href="<?php echo $s_home; ?>login/">Login</a>
			<a href="<?php echo $s_home; ?>register/">Register</a>
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
			foreach ($s_usernavlinks as $s_usernavlink) {
				?>
				<a href="<?php echo $s_home . $s_usernavlink[1]; ?>" class="mob-user"><?php echo $s_usernavlink[0]; ?></a>
				<?php
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
			<a id="mob-usernav-b"><i class="fa fa-user"></i></a>
		</div>
		</div>
	</div>
</div>
<div class="container">