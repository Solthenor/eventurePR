<?php  // In this page the user can see a list of the events he/she has created.
require_once('mobileRedirect.php');
require_once('logoutHandler.php');
require_once('db.php');
require_once('checkAuth.php');

// If the user is not logged in, redirect to the main page.
if (!$loggedin && !isset($userID)) {
    header('Location: index.php');
    return;
}

$db = db::getInstance();

// Query to get all the events that match the user's ID as the creator
$sql = "SELECT
            E.eventName,
            E.eventType,
            E.genre,
            E.flyer,
            DATE_FORMAT(E.date, '%W, %M %e, %Y') as date,
            E.startHour,
            E.endHour,
            E.status,
            E.featured,
            E.price,
            E.flag,
            E.description,
            E.eventID
        FROM Event E
        WHERE E.userID = {$id}
";

$stmt = $db->prepare($sql);
$stmt->execute();

$events = $stmt->fetchAll();

?>
<!DOCTYPE html>
<html>
<head>
    <title>Concerts - E-venturePR</title>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <!-- Links to the CSS stylesheets, Bootstrap, etc. -->
    <link rel='stylesheet' type='text/css' href='http://cdn1.editmysite.com/editor/libraries/fancybox/fancybox.css?1346362758'>
    <link rel='stylesheet' href='http://cdn1.editmysite.com/editor/images/common/common-v2.css?buildTime=1346362758' type='text/css' />
    <link rel='stylesheet' type='text/css' href='css/main_style.css' title='wsite-theme-css' />
    <link href='http://cdn1.editmysite.com/editor/fonts/Capture_it/font.css?2' rel='stylesheet' type='text/css' />
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <style type='text/css'>
        #wsite-content div.paragraph, #wsite-content p, #wsite-content .product-block .product-title, #wsite-content .product-description, .blog-sidebar div.paragraph, .blog-sidebar p, .wsite-form-field label, .wsite-form-field label {}
        #wsite-content h2, #wsite-content .product-long .product-title, #wsite-content .product-large .product-title, #wsite-content .product-small .product-title, .blog-sidebar h2 {}
        #wsite-title{font-family:'Capture it' !important;color:#009900 !important;}
            /*<!--#wsite-content a:link, .blog-sidebar a:link{color:#FFFFFF !important;}  -->    */
            /*#wsite-content a:visited, .blog-sidebar a:visited{color:#FFFFFF !important;}
       #wsite-content a:hover, .blog-sidebar a:hover{color:#FFFFFF !important;} */
    </style>
    <style type='text/css'>
        .wsite-header {
            background-image: url(uploads/1/3/4/4/13443306/header_images/1346208841.jpg) !important;
            background-position: 0 0 !important;
        }
    </style>

    <!-- Links to the javasripts, JQuery, etc, scripts -->
    <script type='text/javascript'><!--
    var STATIC_BASE = 'http://cdn1.editmysite.com/';
    var STYLE_PREFIX = 'wsite';
    //-->
    </script>
    <script type='text/javascript' src='https://ajax.googleapis.com/ajax/libs/jquery/1.8.1/jquery.min.js'></script>
    <script type='text/javascript' src='http://cdn1.editmysite.com/editor/libraries/jquery_effects.js?1346362758'></script>
    <script type='text/javascript' src='http://cdn1.editmysite.com/editor/libraries/fancybox/fancybox.min.js?1346362758'></script>
    <script type='text/javascript' src='http://cdn1.editmysite.com/editor/images/common/utilities-jq.js?1346362758'></script>
    <script type='text/javascript' src='http://cdn1.editmysite.com/editor/libraries/flyout_menus_jq.js?1346362758'></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="http://code.jquery.com/jquery-latest.js"></script>
    <script type='text/javascript'>
    </script>
</head>
<body class='wsite-theme-dark tall-header-page wsite-page-concerts'>
<div id="wrapper">
    <table id="header">
        <tr> <!-- Website logo -->
            <td id="logo"><span class='wsite-logo'><a href='index.php'><span id="wsite-title">E-venturePR</span></a></span></td>
            <td id="header-right">
                <table style="width:150px;">
                    <!-- Checks if the user is logged to show the "Profile | Sign out" links, if not it shows "Register | Login" links -->
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

    <!-- This shows the navigation bar. -->
    <div id="navigation">
        <ul><li id='active'><a href='index.php'>Home</a></li><li id='pg145650631833651339'><a href='events.php?category=Concert'>Music</a></li><li id='pg404778243583026952'><a href='events.php?category=Sports'>Sports</a></li><li id='pg441792526610757515'><a href='events.php?category=Entertainment'>Entertainment</a></li><li id='pg269210016325162137'><a href='events.php?category=Business'>Business & Education</a></li><li id="pgabout_us"><a href="about.php">About Us</a></li></ul>

        <!-- Here starts the container of all the main things -->
        <div id="container" style="margin-top: 29px;">
            <div id="content">
                <!-- Button to go back to the user's profile -->
                <div style="text-align: left;"><a class="btn btn-eventPR" href="profile.php"><span style="font-weight: bold; font-size: 14px; font-family: Arial sans-serif;">GO BACK TO PROFILE</span></a></div>
                <div class="text"><div id='wsite-content' class='wsite-not-footer'>

                    <!-- Loop that shows all the events from the result of the query (the events he/she created) -->
                    <?php

                    foreach ($events as $event) {

                        ?>

                        <div><div style="height: 20px; overflow: hidden; width: 100%;"></div>
                            <hr class="styled-hr" style="width:100%;">
                            <div style="height: 20px; overflow: hidden; width: 100%;"></div></div>

                        <div><div class="wsite-multicol"><div class='wsite-multicol-table-wrap' style='margin:0 -15px'>
                            <table class='wsite-multicol-table'>
                                <tbody class='wsite-multicol-tbody'>
                                <tr class='wsite-multicol-tr'>
                                    <td class='wsite-multicol-col' style='width:35%;padding:0 15px'>

                                        <!-- Shows the event's name -->
                                        <h2 style="text-align:left;"><?php echo $event['eventName'] ?></h2>
                                        <!-- SHows the event's picture -->
                                        <span class='imgPusher' style='float:left;height:0px'></span><span style='position:relative;float:left;z-index:10;;clear:left;margin-top:0px;*margin-top:0px'><a href="event.php?eventID=<?php echo $event['eventID'] ?>"><img class="wsite-image galleryImageBorder" src="picture.php?picID=<?php echo $event['flyer'] ?>" style="margin-top: 5px; margin-bottom: 10px; margin-left: 0px; margin-right: 10px; border-width:1px;padding:3px;" alt="Picture" width="200" height="300"/></a><div style="display: block; font-size: 90%; margin-top: -10px; margin-bottom: 10px; text-align: center;"></div></span>
                                        <hr style="clear:both;visibility:hidden;width:100%;">

                                        <!-- Shows the "More Info" button and redirects to the event's profile -->
                                        <div style="display: inline;"><div style="float:left; display: inline-block;"> </div>
                                            <a class="btn btn-eventPR" href="event.php?eventID=<?php echo $event['eventID'] ?>"><span style="font-weight: bold; font-size: 14px; font-family: arial sans-serif;">MORE INFO</span></a>
                                            <div style="height: 10px; overflow: hidden;"></div></div>

                                    </td>
                                    <td>
                                        <!-- Shows some of the event's info -->
                                        <div class="paragraph" style="text-align:left;display:block;"><font size="4"><?php echo $event['date'] ?></font><br /><font size="4"><?php echo $event['venueName'] ?></font><br /><font size="4"><span style="line-height: 27px;"><br /></span></font><br /><font size="4"><span style="line-height: 27px;">Genre: <?php echo $event['genre'] ?></span></font></div>

                                    </td>
                                    <td class='wsite-multicol-col' style='width:20.925110132159%;padding:0 15px'>

                                        <div class="btn-toolbar" style=" position:relative; padding: 60px 10px 0 0; text-align:center; ">
                                        <div class="btn-group btn-group-vertical">

                                            <!-- Find tickets button -->
                                                <a class="btn btn-eventPR" href="http://www.google.com/search?q=<?php echo $event['eventName'] ?>+tickets" >
                                                    <span style="font-weight: bold; font-size: 14px; font-family: arial sans-serif;  text-transform: capitalize;">Find tickets</span>
                                                </a>

                                        </div>
                                    </div>

                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div></div></div>

                        <?php
                    }
                    ?>

                </div>
            </div>
        </div>
        <div id="footer"></div>
        <div class="clear"></div>
    </div>

</body>
</html>