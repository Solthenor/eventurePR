<?php       // Verifies if user has a cookie set to identify if he has a session open

if(isset($_COOKIE['loggedin'])){
	$loggedin = true;
	$id = $_COOKIE['loggedin'];
}

?>