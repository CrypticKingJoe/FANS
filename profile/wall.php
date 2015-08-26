<?php
require "../inc/Settings.php";
require "../inc/Global.php";

if (isset($_GET['ID'])) {
	$ID = addslashes($_GET['ID']);

	if (isset($_POST['wall-comment'])) {
		if (!empty($_POST['wall-comment'])) {
			$comment = addslashes(strip_tags($_POST['wall-comment']));
			if ($s_profile_wall_chars == 0 || strlen($_POST['wall-comment']) <= $s_profile_wall_chars) {
				$uid = $user['ID'];
				$dateUnix = time();
				$insQ = $db->prepare("INSERT INTO `wall` (`UserID`, `ProfileID`, `Comment`, `DateUnix`) VALUES ('$uid', '$ID', '$comment', '$dateUnix')");
				$insQ->execute();
				echo "1";
				die();
			}
		}
	}
	
	
	if (isset($_GET['get'])) {
		$commentsQ = $db->prepare("SELECT * FROM `wall` WHERE `ProfileID`='$ID' ORDER BY `ID` DESC");
		$commentsQ->execute();
		
		$result = '';
		
		while ($comment = $commentsQ->fetch(PDO::FETCH_ASSOC)) {
			$t_comment = stripslashes(str_replace("\n","<nl></nl>", $comment['Comment']));
			$t_date = date("j F Y", $comment['DateUnix']);
			$t_userID = $comment['UserID'];
			
			$commenterQ = $db->prepare("SELECT * FROM `users` WHERE `ID`='$t_userID'");
			$commenterQ->execute();
			$commenter = $commenterQ->fetch(PDO::FETCH_ASSOC);
			
			$t_userName = $commenter['Username'];
			
			$result .= $t_date . ':' . $t_userID . ':' . $t_userName . ':' . $t_comment . '
';
		}
		
		echo nl2br($result);
		die();
	}
}