<?php
$TITLE = "Account Creation";

require "../inc/Settings.php";
require "../inc/Head.php";

if ($logged) {
	header('location: ../');
	die();
}

$error = 0;
$username = '';
$email = '';
if (isset($_POST['register'])) {
	if (isset($_POST['username']) && isset($_POST['password']) && isset($_POST['rpassword']) && isset($_POST['email'])) {
		if (!empty($_POST['username']) && !empty($_POST['password']) && !empty($_POST['rpassword']) && !empty($_POST['email'])) {
			$username = addslashes($_POST['username']);
			$salt = generateSalt();
			$password = encrypt($_POST['password'], $salt);
			$email = $_POST['email'];
			
			$checkQ = $db->prepare("SELECT * FROM `users` WHERE `Username`='$username'");
			$checkQ->execute();
			$check = $checkQ->fetch(PDO::FETCH_ASSOC);

			if ($check == 0) {
				if (strlen($username) < $s_register_username_min)
					$error = 3;
				else {
					if (strlen($username) > $s_register_username_max)
						$error = 4;
					else {
						$whitelist = array_merge(range('A','Z'), range('a','z'));
						if ($s_register_username_whitespaces)
							array_push($whitelist, ' ');
						for ($i = 0; $i <= 9; $i++)
							array_push($whitelist, strval($i));

						$uarr = str_split($username);
						foreach ($uarr as $uchar) {
							$ok = false;
							foreach ($whitelist as $wchar) {
								if ($uchar == $wchar) {
									$ok = true;
								}
							}
							if (!$ok) {
								$error = 5;
							}
						}
						
						if ($error == 0) {
							if (strlen($_POST['password']) >= $s_register_password_min) {
								if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
									if ($_POST['password'] == $_POST['rpassword']) {
										$dateUnix = time();
										$crQ = $db->prepare("INSERT INTO `users` (`Username`, `Password`, `Salt`, `Email`, `DateUnix`) VALUES
											('$username', '$password', '$salt', '$email', '$dateUnix')");
										$crQ->execute();

										$getQ = $db->prepare("SELECT * FROM `users` WHERE `Username`='$username'");
										$getQ->execute();
										$get = $getQ->fetch(PDO::FETCH_ASSOC);

										$_SESSION['logged'] = true;
										$_SESSION['uid'] = $get['ID'];

										header('location: ' . $s_home);
										die();
									} else
										$error = 8;
								} else
									$error = 7;
							} else
								$error = 6;
						}
					}
				}
			} else
				$error = 2;
		} else
			$error = 1;
	} else
		$error = 1;
}
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
	<?php
	if ($error > 0) {
		?>
		<div class="error">
			<i class="fa fa-times"></i>
			<?php
			switch ($error) {
				case 1:
					echo "All fields must be filled in";
					break;
				case 2:
					echo "Username is already in use";
					break;
				case 3:
					echo "Username must be at least " . $s_register_username_min . " characters long";
					break;
				case 4:
					echo "Username cannot be more than " . $s_register_username_max . " characters long";
					break;
				case 5:
					if ($s_register_username_whitespaces)
						echo "Username must contain alphanumeric characters and whitespaces only";
					else
						echo "Username must contain alphanumeric characters only";
					break;
				case 6:
					echo "Password must be at least" . $s_register_password_min . " characters long";
					break;
				case 7:
					echo "Email must be in a valid format";
					break;
				case 8:
					echo "Password and retype password must match";
					break;
			}
			?>
		</div>
		<?php
	}
	?>
	<div class="input-group">
		<input type="text" name="username" id="username" class="input input-short" placeholder="Username" value="<?php echo $username; ?>" />
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
		<input type="email" name="email" id="email" class="input input-short" placeholder="Email Address" value="<?php echo $email; ?>" />
		<span class="input-msg-red" id="err4"></span>
		<span class="input-msg-green" id="good4"></span>
	</div>
	
	<input type="submit" class="btn btn-blue" name="register" value="Register" />
</form>