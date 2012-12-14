<?php  // This page displays the user's profile
require_once('db.php');
require_once('checkAuth.php');
require_once('logoutHandler.php');

$userID = $_GET['userID'];

// Checks if user is logged in, otherwise returns index
if (!$loggedin && !isset($userID)) {
    header('Location: index.php');
    return;
}

$friendProfile = false;

$db = db::getInstance();

// Checks if this is another user's profile
if(isset($userID) && $id != $userID) {
    $friendProfile = true;
    $friendID = $userID;
    $isFriend = false;

    // Query to check if this person is a friend or not
    $sql = "SELECT
                userID2
            FROM AddFriend
            WHERE userID1 = {$id}
            AND userID2 = {$friendID};
    ";

    $stmt = $db->prepare($sql);
    $stmt->execute();

    $result = $stmt->fetchAll();

    if(count($result[0]) > 0) {
        $isFriend = true;
    }

    // Query to get the info of the owner of the profile if it's not the user
    $sql = "SELECT
                userName,
                userID,
                firstName,
                lastName,
                email,
                profilePicture,
                age,
                gender,
                work
            FROM User
            WHERE userID = {$friendID};
    ";

    $stmt = $db->prepare($sql);
    $stmt->execute();

    $result = $stmt->fetchAll();

    $user = $result[0];
}
else {
    // Query to get the user's info if it's his/her own profile
    $sql = "SELECT
                userName,
                userID,
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
}

if(!isset($user)){
    header('Location: index.php');
    return;
}
// If the submit button for uploading a comment to the wall was pressed, run this code.
if(isset($_POST['submit'])) {
    if($friendProfile) {
        $sql = "INSERT INTO Wall
                SET
                   userID = {$friendID},
                   content = '{$_POST['comment-text']}',
                   posterID = {$id};";
    }
    else {
        $sql = "INSERT INTO Wall
                SET
                   userID = {$id},
                   content = '{$_POST['comment-text']}',
                   posterID = {$id};";
    }

    $stmt = $db->prepare($sql);
    $stmt->execute();
}

// If the add Friend button is pressed run this query.
if(isset($_POST['addFriend'])) {
    $sql = "INSERT INTO AddFriend
            SET
                userID1 = '{$id}',
                userID2 = '{$friendID}'
                ;";

    $stmt = $db->prepare($sql);
    $stmt->execute();
    $isFriend = true;
}

?>
<!DOCTYPE html>
<html>
<!--
Profile page

Dynamically changes depending on the user accessing it
 -->
<head>
    <title>Profile - E-venturePR</title>

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
        #wsite-content a:link, .blog-sidebar a:link{color:#FFFFFF}
        #wsite-content a:visited, .blog-sidebar a:visited{color:#FFFFFF}
        #wsite-content a:hover, .blog-sidebar a:hover{color:#FFFFFF}
    </style>

    <!-- Links to the javasripts, JQuery, etc, scripts -->
    <script type='text/javascript' src='https://ajax.googleapis.com/ajax/libs/jquery/1.8.1/jquery.min.js'></script>
    <script type='text/javascript' src='http://cdn1.editmysite.com/editor/libraries/jquery_effects.js?1346362758'></script>
    <script type='text/javascript' src='http://cdn1.editmysite.com/editor/libraries/fancybox/fancybox.min.js?1346362758'></script>
    <script type='text/javascript' src='http://cdn1.editmysite.com/editor/images/common/utilities-jq.js?1346362758'></script>
    <script type='text/javascript' src='http://cdn1.editmysite.com/editor/libraries/flyout_menus_jq.js?1346362758'></script>
    <script src="js/bootstrap.min.js"></script>
     <link rel="stylesheet" href="http://code.jquery.com/ui/1.9.2/themes/base/jquery-ui.css" />
    <script src="http://code.jquery.com/jquery-1.8.3.js"></script>
    <script src="http://code.jquery.com/ui/1.9.2/jquery-ui.js"></script>
    
    <style type="text/css">@import "jquery.themes.css";</style> 
    <script type="text/javascript" src="jquery.themes.js"></script>
    <link href="css/dark-hive/jquery-ui-1.9.2.custom.css" rel="stylesheet">
    <script src="js/jquery-1.8.3.js"></script>
    <script src="js/jquery-ui-1.9.2.custom.js"></script>
    <!-- Script for showing the Upcoming event's the user wants to go -->
    <script>
    $(function() {
        $( "#accordion" ).accordion({ heightStyle: "fill" });
    });
    </script>
     <style>
    #accordion-resizer {
        padding: 10px;
        width: 350px;
        height: 220px;
    }
    </style>
    <script>
    $(function() {
        $( "#accordion" ).accordion({
            heightStyle: "fill"
        });
    });
    $(function() {
        $( "#accordion-resizer" ).resizable({
            minHeight: 140,
            minWidth: 200,
            resize: function() {
                $( "#accordion" ).accordion( "refresh" );
            }
        });
    });
    </script>
</head>
<body class='wsite-theme-dark no-header-page wsite-page-nightwish-detail'>
<div id="wrapper">
<table id="header">
    <tr> <!-- Website logo -->
        <td id="logo"><span class='wsite-logo'><a href="index.php"><span id="wsite-title">E-venturePR</span></a></span></td>
        <td id="header-right">
            <table style="width: 150px;">

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
</div>

<!-- Here starts the container of all the main things -->
<div id="container">
    <div id="content">
        <div class="text"><div id='wsite-content' class='wsite-not-footer'>
            <div><div class="wsite-multicol"><div class='wsite-multicol-table-wrap' style='margin:0 -15px'>
                <table class='wsite-multicol-table'>
                    <tbody class='wsite-multicol-tbody'>
                    <tr class='wsite-multicol-tr'>
                        <td class='wsite-multicol-col' style='width:61.742006615215%;padding:0 15px'>
                            <!-- Display the user's name -->
                            <h2 style="text-align:left;"><?php echo $user['firstName'] ?> <?php echo $user['lastName'] ?></h2>

                            <!-- Checks to see if this is another user's profile and if he/she is not a frined yet,
                                 it shows the "Add Friend" button -->
                            <?php if($friendProfile && !$isFriend) { ?>

                            <form action="<?php echo $_SERVER['PHP_SELF'] . "?userID={$friendID}"; ?>" method="POST">
                                <input  style="height: 35px;" type="submit" class="btn btn-eventPR" name="addFriend" id="addFriend" value="Add Friend"/>
                            </form>

                            <?php }?>

                            <!-- Displays the user's profile picture -->
                            <span class='imgPusher' style='float:left;height:0px'></span><span style='position:relative;float:left;z-index:10;;clear:left;margin-top:0px;*margin-top:0px'><a><img class="wsite-image galleryImageBorder" src="picture.php?picID=<?php if ($user['profilePicture'] == false) {echo "defaultPic.jpg";} else {echo $user['profilePicture'];} ?>" style="margin-top: 5px; margin-bottom: 10px; margin-left: 0px; margin-right: 10px; border-width:1px;padding:3px;width:200px;" alt="Picture" /></a><div style="display: block; font-size: 90%; margin-top: -10px; margin-bottom: 10px; text-align: center;"></div></span>
                            <!-- Displays teh user's info -->
                            <div class="paragraph" style="text-align:left;display:block;float:left;">Username: <br />Age: <br />Gender: <br />Work: <br />E-mail: </div>
                            <div class="paragraph"style="text-align:center;display:block;float:left;"><?php echo $user['userName'] ?><br /><?php echo $user['age'] ?><br /><?php echo $user['gender'] ?><br /><?php echo $user['work'] ?><br /><?php echo $user['email'] ?></div>

                            <!-- If this is not a friends profile, it is my own. Displays the button-toolbar for
                                 seeing friends, seeing my created events, creating a new event, creating a new venue,
                                 or editing my profile info. -->
                            <?php if(!$friendProfile) { ?>
                            <hr style="clear:both;visibility:hidden;width:100%;" />
                            <div class="btn-toolbar" style="padding: 10px 10px 0 0; display: inline-block;text-align: center; ">
                                <div class="btn-group">

                                    <a href="friends.php" class="btn btn-eventPR"><span style="font-weight: bold; font-size: 14px; font-family: arial sans-serif; text-transform: capitalize">Friends</span></a>
                                    <a href="myEvents.php" class="btn btn-eventPR"><span style="font-weight: bold; font-size: 14px; font-family: arial sans-serif; text-transform: capitalize">My E-vents</span></a>
                                    <a href="create-event.php" class="btn btn-eventPR"><span style="font-weight: bold; font-size: 14px; font-family: arial sans-serif; text-transform: capitalize">Create Event</span></a>
                                    <a href="create-venue.php" class="btn btn-eventPR"><span style="font-weight: bold; font-size: 14px; font-family: arial sans-serif; text-transform: capitalize">Create Venue</span></a>                                    
                                    <a href="editProfile.php" class="btn btn-eventPR"><span style="font-weight: bold; font-size: 14px; font-family: arial sans-serif; text-transform: capitalize">Edit Profile</span></a>


                                </div>

                            </div>

                            <?php } ?>

                        </td>
                        <td class='wsite-multicol-col' style='width:38.257993384785%;padding:0 15px'>

                            <!-- Displays recommended events with links to those events -->
                            <div class="friends_list">
                                <div>
                                    <h4>Recommended E-ventures:</h4>

                                </div>
                            </div>
                            <div>
                                <div class="wsite-multicol"><div class='wsite-multicol-table-wrap' style='margin:0 -15px'>
                                    <table class='wsite-multicol-table'>
                                        <tbody class='wsite-multicol-tbody'>
                                        <tr class='wsite-multicol-tr'>
                                            <td class='wsite-multicol-col' style='width:50%;padding:0 15px'>

                                                <div id="mainmenu">
                                                    <ul style="font-size: 14px; color: white;">


                                                        <!-- Selects random events to reccomend to the user-->

                                                        <?php

                                                        $sql = "SELECT
                                                                           eventID,
                                                                           eventName
                                                                       FROM Event AS r1
                                                                           JOIN (SELECT (RAND() * (SELECT MAX(eventID) FROM Event)) AS id) AS r2
                                                                       WHERE r1.eventID >= r2.id
                                                                       ORDER BY r1.eventID ASC
                                                                       LIMIT 3;
                                                               ";

                                                        $stmt = $db->prepare($sql);
                                                        $stmt->execute();

                                                        $result = $stmt->fetchAll();

                                                        foreach ($result as $event) {
                                                            echo "<li><a href='event.php?eventID={$event['eventID']}'> <span style='color: white'>{$event['eventName']}</span></a></li>
                                                                   <div style='height: 20px; overflow: hidden; width: 100%;''></div>";
                                                        }
                                                        ?>
                                                    </ul>



                                                </div>

                                            </td>

                                        </tr>
                                        </tbody>
                                    </table>
                                </div></div></div></div>
            </div>

                </td>
                </tr>
                </tbody>
                </table>
            </div></div></div>

        <div><div class="wsite-multicol"><div class='wsite-multicol-table-wrap' style='margin:0 -15px'>
            <table class='wsite-multicol-table'>
                <tbody class='wsite-multicol-tbody'>
                <tr class='wsite-multicol-tr'>
                    <td class='wsite-multicol-col' style='width:50%;padding:0 15px'>

                        <!-- Show upcomming events -->
                        <h2 style="text-align:center;">Upcoming Events</h2>

                        <div id="mainmenu">
                            <div class="ui-widget-content">
                                    <div id="accordion">
                                    <!-- Selects events where there user has clicked as I wanna go!-->
                                    <?php $db = db::getInstance();
                                        
                                        if(!$friendProfile) {
                                        $sql = "SELECT
                                            E.eventID,
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
                                            E.userID
                                        FROM Event AS E
                                        INNER JOIN Attends A ON E.eventID=A.eventID
                                        WHERE A.userID={$id};
                                                   ";
                                               }
                                               else {
                                                $sql = "SELECT
                                            E.eventID,
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
                                            E.userID
                                        FROM Event AS E
                                        INNER JOIN Attends A ON E.eventID=A.eventID
                                        WHERE A.userID={$friendID};";

                                               }

                                    $stmt = $db->prepare($sql);
                                    $stmt->execute();

                                    $result = $stmt->fetchAll();

                                    // Loop that displays the events.
                                    foreach ($result as $event) { ?>


                                        <h3><?php echo $event['eventName'] ?></h3>
                                        <div>
                                            <a href='event.php?eventID=<?php echo $event['eventID']?>'><img src='picture.php?picID=<?php echo $event['flyer']?>' alt='img/No-image-available.jpg' style="max-width: 30%; float:left;"></a>
                                            <p style="float:left"><?php echo $event['description'] ?></p>
                                        </div>
                                        
                                    
                                    
                                    
                                    
                                          
                                <?php } ?>
                                </div>
                                </div>

                        </div>

                    </td>
                    <td class='wsite-multicol-col' style='width:50%;padding:0 15px'>

                        <h2 style="text-align:left;"><?php echo $user['userName']?>'s wall:<br /></h2>
                        <div class="media" style="border: 1px solid #f5f5f5; padding: 20px; height: 60%; overflow: auto; background-color:black;">

                            <ul style="font-size: 14px; color: white;">

                                <!--  Selects comments posted to user's wall -->
                                <?php

                                $db = db::getInstance();
                                if(!$friendProfile) { 
                                    $sql = "SELECT
                                               c1.userID,
                                               c1.posterID,
                                               c1.content,
                                               U.profilePicture
                                           FROM Wall c1 INNER JOIN User U ON c1.posterID=U.userID
                                           WHERE c1.userID='{$id}';
                                    ";
                                }
                                else {
                                    $sql = "SELECT
                                               c1.userID,
                                               c1.posterID,
                                               c1.content,
                                               U.profilePicture
                                           FROM Wall c1 INNER JOIN User U ON c1.posterID=U.userID
                                           
                                           WHERE c1.userID='{$friendID}';
                                    ";
                                }

                                $stmt = $db->prepare($sql);
                                $stmt->execute();

                                $result = $stmt->fetchAll();

                                // Display the comments on user's wall -->
                                foreach ($result as $comment) {
                                    echo "<li> 
                                            <a href='profile.php?userID={$comment['posterID']}'><img class='wsite-image galleryImageBorder' src='picture.php?picID={$comment['profilePicture']}' alt='img/default-profile.jpg' style='max-width: 15%; float:left; border-width:1px;'></a>
                                            <span style='color: white; display:inline-block;margin-top:7px;'> : {$comment['content']}</span>
                                          </li>
                                        <div style='height: 20px; overflow: hidden; width: 100%;'></div>";

                                           


                                }
                                ?>
                            </ul>

                            <hr style="clear:both;visibility:hidden;width:100%;">

                        </div>

                        <!-- Textbox and button for uploading a comment to friend's wall -->
                        <?php if($friendProfile) { ?>
                        <form action="<?php echo "profile.php?userID={$friendID}" ?>" method="POST" id="submit" enctype="multipart/form-data">
                        <?php } else {?>
                        <form action="profile.php" method="POST" id="submit" enctype="multipart/form-data">
                        <?php } ?>
                        <div><div class="wsite-form-field" style="margin:5px 0px 5px 0px; text-align:right;">
                            <label class="wsite-form-label" for="description">Post to wall: <span class="form-required">*</span></label>
                            <div class="wsite-form-input-container">
                                <textarea id="description" class="wsite-form-input wsite-input" name="comment-text" style="width:285px; height: 50px"></textarea>
                            </div>
                            <div id="instructions-740288841696996782" class="wsite-form-instructions" style="display:none;"></div>
                        </div></div>
                        <div style="text-align:right; margin-top:10px; margin-bottom:10px;">
                            <input type='submit' name="submit" value="Submit" class='btn btn-eventPR' />
                        </div>
                    </form>


        </div></div>

            </td>
            </tr>
            </tbody>
            </table>
        </div></div></div></div>
</div>
</div>
</div>
<div id="footer"></div>
<div class="clear"></div>
</div>

</body>
</html>