<?php

if(isset($_POST['loggedOut'])  &&  $_POST['loggedOut'] == 'logout'){
	setcookie('loggedin', false);
	header('Location: index.php');
	return;
}

if(isset($_POST['mloggedOut'])  &&  $_POST['mloggedOut'] == 'logout'){
    setcookie('loggedin', false);
    header('Location: mobile-index.php');
    return;
}

?>