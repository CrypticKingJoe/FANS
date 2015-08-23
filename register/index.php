<?php
$TITLE = "Account Creation";

require "../inc/Settings.php";
require "../inc/Head.php";
?>
<script>
	$(document).ready(function() {
		$('#username').keyup(function() {
			$.ajax({
				method: 'GET',
				url: '../api/register.php',
				data: { username: $('#username').val() }
			}).done(function(data) {
				$('#err1').html("");
				$('#good1').html("");
				
				switch (data) {
					case "0":
						$('#good1').html("<i class='fa fa-check'></i>");
						break;
					case "1":
						$('#err1').html("<i class='fa fa-times'></i> Username is already in use");
						break;
					case "2":
						$('#err1').html("<i class='fa fa-times'></i> Username must be at least <?php echo $s_register_username_min; ?> characters long");
						break;
					case "3":
						$('#err1').html("<i class='fa fa-times'></i> Username cannot be longer than <?php echo $s_register_username_max; ?> characters");
						break;
					case "4":
						$('#err1').html("<i class='fa fa-times'></i> Username can only contain alphanumeric characters <?php if ($s_register_username_whitespaces) echo 'and spaces'; ?>");
						break;
				}
			});
		});
		
		$('#password').keyup(function() {
			$.ajax({
				method: 'POST',
				url: '../api/register.php',
				data: { password: $('#password').val() }
			}).done(function(data) {
				$('#err2').html("");
				$('#good2').html("");
				
				switch (data) {
					case "0":
						$('#good2').html("<i class='fa fa-check'></i>");
						break;
					case "1":
						$('#err2').html("<i class='fa fa-times'></i> Password must contain at least <?php echo $s_register_password_min; ?> characters");
						break;
				}
			});
		});
		
		$('#rpassword').keyup(function() {
			$('#err3').html("");
			$('#good3').html("");
			if ($('#rpassword').val() == $('#password').val()) {
				$('#good3').html("<i class='fa fa-check'></i>");
			} else {
				$('#err3').html("<i class='fa fa-times'></i> Retype password must match password</i>");
			}
		});
		
		$('#email').keyup(function() {
			$.ajax({
				method: 'GET',
				url: '../api/register.php',
				data: { email: $('#email').val() }
			}).done(function(data) {
				$('#err4').html("");
				$('#good4').html("");
				
				switch (data) {
					case "0":
						$('#good4').html("<i class='fa fa-check'></i>");
						break;
					case "1":
						$('#err4').html("<i class='fa fa-times'></i> Email is invalid.");
						break;
				}
			});
		});
	});
</script>
<h1>Register</h1>
<p>Already have an account? <a href="../login/">Click here to login</a>.</p>
<hr /><br />
<form action="" method="post">
	<div class="input-group">
		<input type="text" name="username" id="username" class="input input-short" placeholder="Username" />
		<span class="input-msg-red" id="err1"></span>
		<span class="input-msg-green" id="good1"></span>
	</div>
	<div class="input-group">
		<input type="password" name="password" id="password" class="input input-short" placeholder="Password" />
		<span class="input-msg-red" id="err2"></span>
		<span class="input-msg-green" id="good2"></span>
	</div>
	<div class="input-group">
		<input type="password" name="rpassword" id="rpassword" class="input input-short" placeholder="Retype Password" />
		<span class="input-msg-red" id="err3"></span>
		<span class="input-msg-green" id="good3"></span>
	</div>
	<div class="input-group">
		<input type="email" name="email" id="email" class="input input-short" placeholder="Email Address" />
		<span class="input-msg-red" id="err4"></span>
		<span class="input-msg-green" id="good4"></span>
	</div>
	
	<input type="submit" class="btn btn-blue" value="Register" />
</form>