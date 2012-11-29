<?php
require_once('mobileRedirect.php');
require_once('db.php');
require_once('checkAuth.php');
require_once('logoutHandler.php');

$userID = $_GET['userID'];

// Checks if user is logged in, otherwise returns index
if (!$loggedin && !isset($userID)) {
    header('Location: index.php');
    return;
}


if(isset($userID)) {
    $id = $userID;
}

// Query to select a profile depending on the userID provided

$db = db::getInstance();
$sql = "SELECT
            userName,
            firstName,
            lastName,
            email,
            profilePicture,
            age,
            gender,
            work
        FROM User
        WHERE userID = {$id};
";

$stmt = $db->prepare($sql);
$stmt->execute();

$result = $stmt->fetchAll();

$user = $result[0];

if(!isset($user)){
    header('Location: index.php');
    return;
}

if(isset($_POST['submit'])) {
    $db = db::getInstance();

    $sql = "INSERT INTO Wall
            SET
               userID = {userID};
               content = '{$_POST['comment-text']}';";

    $stmt = $db->prepare($sql);
    $stmt->execute();

}



?>
<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

    <title>Eventure - Profile</title>
    <link rel="stylesheet" href="css/mobile-style.css" />
    <link rel="stylesheet" href="css/jquery.mobile-1.2.0.css" />
    <link href='http://cdn1.editmysite.com/editor/fonts/Capture_it/font.css?2' rel='stylesheet' type='text/css' />
    <link rel='stylesheet' href='http://cdn1.editmysite.com/editor/images/common/common-v2.css?buildTime=1346362758' type='text/css' />
    <link rel="stylesheet" href="css/popups.css" />

    <script src="js/jquery-1.8.2.js"></script>
    <script src="js/jquery.mobile-1.2.0.js"></script>
    

</head>

<body>

<div id="wrapper" style="height: 100%">
    <div id="header" >
        <span class='wsite-logo'><a href='mobile-index.php'><span id="wsite-title">E-venturePR</span></a></span>
        <div data-role="controlgroup" data-type="horizontal" style="float:left; width: 100%" >
            <?php if($loggedin) { ?>
            <a  href="mobile-profile.php" rel="external" data-role="button" data-theme="c" style="height: 40px; font-size: 15px;"  >Profile</a>
            <form style="float:left;" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST" data-ajax="false">
                <input  type='submit' name="mloggedOut" id="mloggedOut" value="logout" class='btn btn-eventPR' />
            </form>

            <?php }  else {?>
            <p style="font-size: 16px;font-weight: bold;text-shadow: none;">Dont have an account?</p>
            <a  href="mobile-register.php"  rel="external" data-role="button" data-theme="c" style="height: 40px; font-size: 15px;"  >Sign up!</a>
            <a  href="mobile-login.php"  rel="external" data-role="button" data-theme="c" style="height: 40px; font-size: 15px;"  >Log in!</a>

            <?php }?>
        </div>
    </div><!-- /header -->


<div id="label" style="margin: auto;padding-top:20px;">

            <span style="font-size: 22px;color: white; font-weight: bold;text-shadow: none">Username:</span>  <span style="font-size: 18px;font-weight: bold;text-shadow: none; color: #32CD32; text-decoration: underline;"><?php echo $user['userName'] ?></span>
            <br>
            <br>
            <span style="font-size: 22px;color: white; font-weight: bold;text-shadow: none">Name:</span>  <span style="font-size: 18px;font-weight: bold;text-shadow: none; color: #32CD32; text-decoration: underline;"><?php echo $user['firstName'] ?> <?php echo $user['lastName'] ?></span>
            <br>
            <br>
            <span style="font-size: 22px;color: white; font-weight: bold;text-shadow: none">Email:</span>  <span style="font-size: 18px;font-weight: bold;text-shadow: none; color: #32CD32; text-decoration: underline;"><?php echo $user['email'] ?></span>
            <br>
            <br>
            <span style="font-size: 22px;color: white; font-weight: bold;text-shadow: none">Gender:</span>  <span style="font-size: 18px;font-weight: bold;text-shadow: none; color: #32CD32; text-decoration: underline;"><?php echo $user['gender'] ?></span>
            <br>
            
            <br>


        </div>
<!--        
<div>

<a href="#popupPanel" data-rel="popup" data-transition="slide" data-position-to="window" data-role="button">Open panel</a>
            
<div data-role="popup" id="popupPanel" data-corners="false" data-theme="none" data-shadow="false" data-tolerance="0,0">

    <button data-theme="a" data-icon="back" data-mini="true">Back</button>
    <button data-theme="a" data-icon="grid" data-mini="true">Menu</button>
    <button data-theme="a" data-icon="search" data-mini="true">Search</button>
     
</div>
-->
</div>

    </div> <!--content-->
</div>         <!--wrapper-->

</body>
</html>