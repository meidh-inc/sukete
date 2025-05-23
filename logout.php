<?php require_once("includes/session.php")?>
<?php require_once("includes/connection.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php //CLOSE THE SESSION (LOG OUT):
		// Four steps to closing a session
		// (i.e. logging out)
		// 1. Find the session
		//session_start();
		// 2. Unset all the session variables
		$_SESSION = array();
		// 3. Destroy the session cookie
		if(isset($_COOKIE[session_name()])) {
			setcookie(session_name(), '', time()-42000, '/');
		}
		// 4. Destroy the session
		session_destroy();
		// 5. Send user to index page with message
		redirect_to("index.php?logout=yes");
?>