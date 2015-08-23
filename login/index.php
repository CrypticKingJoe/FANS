<?php
$TITLE = "Login";

require "../inc/Settings.php";
require "../inc/Head.php";

if ($logged) {
	header('location: ../');
	die();
}

$username = '';
$error = 0;
if (isset($_POST['login'])) {
	if (isset($_POST['username']) && isset($_POST['password'])) {
		if (!empty($_POST['username']) && !empty($_POST['password'])) {
			$username = addslashes($_POST['username']);
			
			$checkQ = $db->prepare("SELECT * FROM `users` WHERE `Username`='$username'");
			$checkQ->execute();
			$check = $checkQ->fetch(PDO::FETCH_ASSOC);
			
			if ($check > 0) {
				$salt = $check['Salt'];
				if (encrypt($_POST['password'], $salt) == $check['Password']) {
					$_SESSION['logged'] = true;
					$_SESSION['uid'] = $check['ID'];
					
					header('location: ../');
					die();
				} else
					$error = 3;
			} else
				$error = 2;
		} else
			$error = 1;
	} else
		$error = 1;
}
?>
<h1>Login</h1>
<p>No account? No problem. <a href="../register/">Click here to make one</a>.</p>
<hr /><br />
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
				echo "Username is not registered. <a href='../register/'>Do you want to create it?</a>";
				break;
			case 3:
				echo "Password is incorrect";
				break;
		}
		?>
	</div>
	<?php
}
?>
<form action="" method="post">
	<div class="input-group">
		<input type="text" name="username" class="input input-short" placeholder="Username" value="<?php echo $username; ?>" />
	</div>
	<div class="input-group">
		<input type="password" name="password" class="input input-short" placeholder="Password" />
	</div>
	<input type="submit" name="login" class="btn btn-blue" value="Login" />
</form>