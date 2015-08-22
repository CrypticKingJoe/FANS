<?php
if (!isset($SETTINGS)) {
	die("Uninitialised");
}
?>
<div class="usernav">
	<div class="wrapper">
		<?php
		foreach ($s_usernavlinks as $s_usernavlink) {
			?>
			<a href="<?php echo $s_home . $s_usernavlink[1]; ?>"><?php echo $s_usernavlink[0]; ?></a>
			<?php
		}
		?>
		<div class="pull-right">
			<a href="login/">Login</a>
			<a href="register/">Register</a>
		</div>
	</div>
</div>
<div class="nav">
	<div class="wrapper">
		<a href="<?php echo $s_home; ?>" class="logoHolder">
			<img class="logo" src="<?php echo $s_home; ?>img/<?php echo $s_logo; ?>" />
		</a>
		<div class="link-group">
			<?php
			foreach ($s_navlinks as $s_navlink) {
				?>
				<a href="<?php echo $s_home . $s_navlink[1]; ?>"><?php echo $s_navlink[0]; ?></a>
				<?php
			}
			?>
		</div>
	</div>
</div>
