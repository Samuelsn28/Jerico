<?php 
	session_set_cookie_params(["httponly" => true]);
	session_start();
	
	session_destroy();

	echo "<script> window.location.href='login.php'; </script>";
?>


