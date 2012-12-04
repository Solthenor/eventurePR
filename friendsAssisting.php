<?php
require_once('db.php');
require_once('logoutHandler.php');
require_once('checkAuth.php');

$userID = $_GET['userID'];
$eventID = $_GET['eventID'];

// Checks if user is logged in, otherwise returns index
if (!$loggedin && !isset($userID)) {
    header('Location: index.php');
    return;
}

if(isset($userID)) {
    $id = $userID;
}

$db = db::getInstance();
$sql = "SELECT
            U.userName,
            U.userID,
            U.firstName,
            U.lastName,
            U.email,
            U.profilePicture,
            U.age,
            U.gender,
            U.work
        FROM User U
        WHERE U.userID in (SELECT F.userID2
                         FROM AddFriend F
                         WHERE F.userID1 = {$id})
        AND U.userID in (SELECT A.userID
                         FROM Attends A
                         WHERE A.eventID = {$eventID});
";

$stmt = $db->prepare($sql);
$stmt->execute();

$result = $stmt->fetchAll();




?>
<!DOCTYPE html>
<html>
<head>
    <title>E-venturePR - My Contacts</title>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

    <link rel='stylesheet' type='text/css' href='http://cdn1.editmysite.com/editor/libraries/fancybox/fancybox.css?1346362758'>
    <link rel='stylesheet' href='http://cdn1.editmysite.com/editor/images/common/common-v2.css?buildTime=1346362758' type='text/css' />
    <link rel='stylesheet' type='text/css' href='css/main_style.css' title='wsite-theme-css' />
    <link href='http://cdn1.editmysite.com/editor/fonts/Capture_it/font.css?2' rel='stylesheet' type='text/css' />
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <style type='text/css'>
        #wsite-content div.paragraph, #wsite-content p, #wsite-content .product-block .product-title, #wsite-content .product-description, .blog-sidebar div.paragraph, .blog-sidebar p, .wsite-form-field label, .wsite-form-field label {}
        #wsite-content h2, #wsite-content .product-long .product-title, #wsite-content .product-large .product-title, #wsite-content .product-small .product-title, .blog-sidebar h2 {}
        #wsite-title{font-family:'Capture it' !important;color:#009900 !important;}
        #wsite-content a:link, .blog-sidebar a:link{color:#FFFFFF }
        #wsite-content a:visited, .blog-sidebar a:visited{color:#FFFFFF }
        #wsite-content a:hover, .blog-sidebar a:hover{color:#FFFFFF }
    </style>
    <script type='text/javascript' src='https://ajax.googleapis.com/ajax/libs/jquery/1.8.1/jquery.min.js'></script>
    <script type='text/javascript' src='http://cdn1.editmysite.com/editor/libraries/jquery_effects.js?1346362758'></script>
    <script type='text/javascript' src='http://cdn1.editmysite.com/editor/libraries/fancybox/fancybox.min.js?1346362758'></script>
    <script type='text/javascript' src='http://cdn1.editmysite.com/editor/images/common/utilities-jq.js?1346362758'></script>
    <script type='text/javascript' src='http://cdn1.editmysite.com/editor/libraries/flyout_menus_jq.js?1346362758'></script>
    <script src="js/bootstrap.min.js"></script>
</head>
<body class='wsite-theme-dark tall-header-page wsite-page-index'>
<div id="wrapper">
    <table id="header">
        <tr>
            <td id="logo"><span class='wsite-logo'><a href='index.php'><span id="wsite-title">E-venturePR</span></a></span></td>
            <td id="header-right">
                <table style="width: 150px;">
                    <?php if($loggedin) { ?>
                    <tr>
                        <td class="phone-number"><span class='wsite-text'><a href="profile.php" style="color: #32CD32; text-decoration: underline; ">Profile</a> | 
                               <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" style="float: right;">
                                   <input type="hidden" value="logout" name="loggedOut" />
                                   <input type="hidden" style="color: #32CD32; text-decoration: underline;" value="Log out" />
                                   <a href="#" onclick="this.parentNode.submit()" style="color: #32CD32; text-decoration: underline; ">Logout</a>
                               </form>
                        </td>

                        <td class="social"></td>
                    </tr>

                    <?php }  else {?>
                    <tr>
                        <td class="phone-number"><span class='wsite-text'>Don't have an account? Register <a href="login.php" style="color: #32CD32; text-decoration: underline; ">HERE</a> | <a href="login.php" style="color: #32CD32; text-decoration: underline;">Sign in</a></span></td>
                        <td class="social"></td>
                    </tr>
                    <?php }?>
                </table>
                <div class="search"></div>
            </td>
        </tr>
    </table>
    <div id="navigation">
        <ul><li id='active'><a href='index.php'>Home</a></li><li id='pg145650631833651339'><a href='events.php?category=Concert'>Music</a></li><li id='pg404778243583026952'><a href='events.php?category=Sports'>Sports</a></li><li id='pg441792526610757515'><a href='events.php?category=Entertainment'>Entertainment</a></li><li id='pg269210016325162137'><a href='events.php?category=Business'>Business & Education</a></li><li id="pgabout_us"><a href="about.php">About Us</a></li></ul>
    </div>
    <div id="container">
        <div id="content">
            <div style="text-align: left;"><a class="btn btn-eventPR" href="event.php?eventID=<?php echo $eventID ?>"><span style="font-weight: bold; font-size: 14px; font-family: Arial sans-serif;">GO BACK TO EVENT</span></a></div>

            <?php if(isset($result)) {?>
            <?php foreach ($result as $user) { ?>

                <div><div style="height: 20px; overflow: hidden; width: 100%;"></div>
                    <hr class="styled-hr" style="width:100%;">
                    <div style="height: 20px; overflow: hidden; width: 100%;"></div></div>

                <div><div class="wsite-multicol"><div class='wsite-multicol-table-wrap' style='margin:0 -15px'>
                    <table class='wsite-multicol-table'>
                        <tbody class='wsite-multicol-tbody'>
                        <tr class='wsite-multicol-tr'>
                            <td class='wsite-multicol-col' style="padding:15px 15px">
                                <h3 style="text-align:left;"><?php echo $user['firstName'] ?> <?php echo $user['lastName'] ?></h3>

                                <span class='imgPusher' style='float:left;height:0px'></span><span style='position:relative;float:left;z-index:10;;clear:left;margin-top:0px;*margin-top:0px'><a><img class="wsite-image galleryImageBorder" src="picture.php?picID=<?php echo $user['profilePicture'] ?>" style="margin-top: 5px; margin-bottom: 10px; margin-left: 0px; margin-right: 10px; border-width:1px;padding:3px;width:200px;" alt="Picture" /></a><div style="display: block; font-size: 90%; margin-top: -10px; margin-bottom: 10px; text-align: center;"></div></span>
                                <div class="paragraph" style="text-align:left;display:block;float:left;">Username: <br />Age: <br />Gender: <br />Work: <br />E-mail: </div>
                                <div class="paragraph"style="text-align:center;display:block;float:left;"><?php echo $user['userName'] ?><br /><?php echo $user['age'] ?><br /><?php echo $user['gender'] ?><br /><?php echo $user['work'] ?><br /><?php echo $user['email'] ?></div>

                                <a class="wsite-button wsite-button-small wsite-button-normal" href="profile.php?userID=<?php echo $user['userID'] ?>" >
                                    <span class="wsite-button-inner">See profile</span>
                                </a>
                            </td>

                        </tr>
                        </tbody>
                    </table>

                </div></div></div>

                <?php }?>
            <?php } ?>

        </div>

    </div>

</div>
</div>
<div id="footer"></div>
<div class="clear"></div>
</div>

</body>
</html>