<?php

if(isset($_POST['loggedOut'])  &&  $_POST['loggedOut'] == 'logout'){
	setcookie('loggedin', false);
	header('Location: index.php');
	return;
}

?>