<?php
require_once('mobileRedirect.php');
require_once('db.php');
require_once('checkAuth.php');

$userID = $_GET['userID'];

if (!$loggedin && !isset($userID)) {
    header('Location: index.php');
    return;
}

if(isset($userID)) {
    $id = $userID;
}

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



?>
<!DOCTYPE html>
<html>
<head>
    <title>Profile - E-venturePR</title>

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
        #wsite-content a:link, .blog-sidebar a:link{color:#FFFFFF}
        #wsite-content a:visited, .blog-sidebar a:visited{color:#FFFFFF}
        #wsite-content a:hover, .blog-sidebar a:hover{color:#FFFFFF}
    </style>
    <script type='text/javascript' src='https://ajax.googleapis.com/ajax/libs/jquery/1.8.1/jquery.min.js'></script>
    <script type='text/javascript' src='http://cdn1.editmysite.com/editor/libraries/jquery_effects.js?1346362758'></script>
    <script type='text/javascript' src='http://cdn1.editmysite.com/editor/libraries/fancybox/fancybox.min.js?1346362758'></script>
    <script type='text/javascript' src='http://cdn1.editmysite.com/editor/images/common/utilities-jq.js?1346362758'></script>
    <script type='text/javascript' src='http://cdn1.editmysite.com/editor/libraries/flyout_menus_jq.js?1346362758'></script>
</head>
<body class='wsite-theme-dark no-header-page wsite-page-nightwish-detail'>
<div id="wrapper">
    <table id="header">
        <tr>
            <td id="logo"><span class='wsite-logo'><a href="index.php"><span id="wsite-title">E-venturePR</span></a></span></td>
            <td id="header-right">
                <table>
                    <?php if($loggedin) { ?>
                    <tr>
                        <td class="phone-number"><span class='wsite-text'><a href="profile.php" style="color: #32CD32; text-decoration: underline; "><?php echo $user['userName'] ?></a> | <a href="index.php" style="color: #32CD32; text-decoration: underline;">Log out</a></span></td>
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
            <div class="text"><div id='wsite-content' class='wsite-not-footer'>
                <div><div class="wsite-multicol"><div class='wsite-multicol-table-wrap' style='margin:0 -15px'>
                    <table class='wsite-multicol-table'>
                        <tbody class='wsite-multicol-tbody'>
                        <tr class='wsite-multicol-tr'>
                            <td class='wsite-multicol-col' style='width:61.742006615215%;padding:0 15px'>

                                <h2 style="text-align:left;"><?php echo $user['firstName'] ?> <?php echo $user['lastName'] ?></h2>
                                <span class='imgPusher' style='float:left;height:0px'></span><span style='position:relative;float:left;z-index:10;;clear:left;margin-top:0px;*margin-top:0px'><a><img class="wsite-image galleryImageBorder" src="picture.php?picID=<?php echo $user['profilePicture'] ?>" style="margin-top: 5px; margin-bottom: 10px; margin-left: 0px; margin-right: 10px; border-width:1px;padding:3px;width:200px;" alt="Picture" /></a><div style="display: block; font-size: 90%; margin-top: -10px; margin-bottom: 10px; text-align: center;"></div></span>
                                <div class="paragraph" style="text-align:left;display:block;float:left;">Username: <br />Age: <br />Gender: <br />Work: <br />E-mail: </div>
                                <div class="paragraph"style="text-align:center;display:block;float:left;"><?php echo $user['userName'] ?><br /><?php echo $user['age'] ?><br /><?php echo $user['gender'] ?><br /><?php echo $user['work'] ?><br /><?php echo $user['email'] ?></div>

                                <hr style="clear:both;visibility:hidden;width:100%;" />
                                <div class="btn-toolbar" style="padding: 10px 10px 0 0; display: inline-block;text-align: center; ">
                                    <div class="btn-group">
                                        <a href="create-event.php" class="btn btn-eventPR"><span style="font-weight: bold; font-size: 14px; font-family: arial sans-serif; text-transform: capitalize">E-vent it!</span></a>
                                        <a href="myEvents.php" class="btn btn-eventPR"><span style="font-weight: bold; font-size: 14px; font-family: arial sans-serif; text-transform: capitalize">My E-vents</span></a>
                                        <a href="create-venue.php" class="btn btn-eventPR"><span style="font-weight: bold; font-size: 14px; font-family: arial sans-serif; text-transform: capitalize">Create Venue</span></a>
                                        <a href="contacts.html" class="btn btn-eventPR"><span style="font-weight: bold; font-size: 14px; font-family: arial sans-serif; text-transform: capitalize">Contacts</span></a>

                                    </div>
                                </div>

                            </td>
                            <td class='wsite-multicol-col' style='width:38.257993384785%;padding:0 15px'>

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
                                                                <?php

                                                               $db = db::getInstance();
                                                               $sql = "SELECT 
                                                                           eventID,
                                                                           eventName
                                                                       FROM Event AS r1 
                                                                           JOIN (SELECT (RAND() * (SELECT MAX(eventID) FROM Event)) AS id) AS r2
                                                                       WHERE r1.eventID >= r2.id
                                                                       ORDER BY r1.eventID ASC
                                                                       LIMIT 3
                                                               ";

                                                               $stmt = $db->prepare($sql);
                                                               $stmt->execute();
                                                               
                                                               $result = $stmt->fetchAll();

                                                               foreach ($result as &$venue) {
                                                                 echo "<li><a href='event.php?eventID={$venue['eventID']}'> <span style='color: white'>{$venue['eventName']}</span></a></li>
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

                                <h2 style="text-align:center;">Memorable E-ventures</h2>
                                <!--
                                <div>
                                    <div><div style="height: 20px; overflow: hidden;"></div>
                                        <div id='139083701912618958-gallery' class='imageGallery' style='line-height: 0px; padding: 0; margin: 0'>
                                            <div id='139083701912618958-imageContainer0' style='float:left;width:33.28%;margin:0;'><div id='139083701912618958-insideImageContainer0' style='position:relative;margin:5px;padding:0 8px 8px 0'><div style='position:relative;width:100%;padding:0 0 75.08%;'><a href='uploads/1/3/4/4/13443306/7495447_orig.jpg' rel='lightbox[gallery139083701912618958]' onclick='if (!window.lightboxLoaded) return false'><img src='uploads/1/3/4/4/13443306/7495447.jpg' class='galleryImage galleryImageBorder' _width='333' _height='225' style='position:absolute;border-width:1px;padding:3px;width:100%;top:5%;left:0%' /></a></div></div></div><div id='139083701912618958-imageContainer1' style='float:left;width:33.28%;margin:0;'><div id='139083701912618958-insideImageContainer1' style='position:relative;margin:5px;padding:0 8px 8px 0'><div style='position:relative;width:100%;padding:0 0 75.08%;'><a href='uploads/1/3/4/4/13443306/8485349_orig.jpg' rel='lightbox[gallery139083701912618958]' onclick='if (!window.lightboxLoaded) return false'><img src='uploads/1/3/4/4/13443306/8485349.jpg' class='galleryImage galleryImageBorder' _width='333' _height='222' style='position:absolute;border-width:1px;padding:3px;width:100%;top:5.6%;left:0%' /></a></div></div></div><div id='139083701912618958-imageContainer2' style='float:left;width:33.28%;margin:0;'><div id='139083701912618958-insideImageContainer2' style='position:relative;margin:5px;padding:0 8px 8px 0'><div style='position:relative;width:100%;padding:0 0 75.08%;'><a href='uploads/1/3/4/4/13443306/2260870_orig.jpg' rel='lightbox[gallery139083701912618958]' onclick='if (!window.lightboxLoaded) return false'><img src='uploads/1/3/4/4/13443306/2260870.jpg' class='galleryImage galleryImageBorder' _width='279' _height='250' style='position:absolute;border-width:1px;padding:3px;width:83.78%;top:0%;left:8.11%' /></a></div></div></div><div id='139083701912618958-imageContainer3' style='float:left;width:33.28%;margin:0;'><div id='139083701912618958-insideImageContainer3' style='position:relative;margin:5px;padding:0 8px 8px 0'><div style='position:relative;width:100%;padding:0 0 75.08%;'><a href='uploads/1/3/4/4/13443306/817215_orig.jpg' rel='lightbox[gallery139083701912618958]' onclick='if (!window.lightboxLoaded) return false'><img src='uploads/1/3/4/4/13443306/817215.jpg' class='galleryImage galleryImageBorder' _width='333' _height='193' style='position:absolute;border-width:1px;padding:3px;width:100%;top:11.4%;left:0%' /></a></div></div></div><span style='display: block; clear: both; height: 0px; overflow: hidden;'></span>
                                        </div>

                                        <div style="height: 20px; overflow: hidden;"></div></div>
                                </div>
                                -->
                                <div id="mainmenu">
                                    <ul style="font-size: 14px; color: white;">
                                        <?php $db = db::getInstance();
                                            $sql = "SELECT 
                                                        eventID,
                                                        eventName
                                                    FROM Event AS r1, User AS u1 
                                                        JOIN (SELECT (RAND() * (SELECT MAX(eventID) FROM Attends)) AS id) AS r2
                                                                       WHERE r1.eventID >= r2.id
                                                                       
                                                                        AND 
                                                                       u1.userID = {$id}

                                                                       ORDER BY r1.eventID ASC
                                                                       LIMIT 5
                                                               ";

                                            $stmt = $db->prepare($sql);
                                            $stmt->execute();
                                                               
                                           $result = $stmt->fetchAll();

                                           foreach ($result as &$venue) {
                                                echo "<li><a href='event.php?eventID={$venue['eventID']}'> <span style='color: white'>{$venue['eventName']}</span></a></li>
                                                <div style='height: 20px; overflow: hidden; width: 100%;''></div>";
                                                }
                                        ?>
                                    </ul>



                                    </div>

                            </td>
                            <td class='wsite-multicol-col' style='width:50%;padding:0 15px'>

                                <h2 style="text-align:left;">My wall:<br /></h2>
                                <div style="border: 1px solid #f5f5f5; padding: 20px; height: 80%; overflow: auto; background-color:black;">
                                    <span class="imgPusher" style="float:left;height:0px"></span>
                                    <div style="position:relative;float:left;z-index:10;width:70px;clear:left;margin-top:0px;*margin-top:0px">
                                        <a><img class="wsite-image galleryImageBorder" src="http://i3.kym-cdn.com/entries/icons/original/000/010/496/asdf.jpg" style="margin-top: 5px; margin-bottom: 10px; margin-left: 0px; margin-right: 10px; border: 1px double gray;padding:3px; background-color: #1a1a1a;" alt="Picture">
                                        </a>
                                        <div style="display: block; font-size: 90%; margin-top: -10px; margin-bottom: 10px; text-align: center;"></div></div>
                                    <!--<div class="paragraph" style="text-align:left;display:block; color: white; font-size: medium; font-style: italic">: HIIIIIIIIIIII!!! &lt;3</div>-->
                                    <ul style="font-size: 14px; color: white;">
                                                                <?php

                                                               $db = db::getInstance();
                                                               $sql = "SELECT 
                                                                           userID,
                                                                           content
                                                                       FROM Comment AS c1 
                                                                           JOIN (SELECT ( * (SELECT MAX(userID) FROM User)) AS id) AS u2
                                                                       WHERE c1.userID >= u2.id
                                                                       ORDER BY c1.userID ASC
                                                                       LIMIT 5
                                                               ";

                                                               $stmt = $db->prepare($sql);
                                                               $stmt->execute();
                                                               
                                                               $result = $stmt->fetchAll();

                                                               foreach ($result as &$comment) {
                                                                 echo "<li> <span style='color: white'>{$comment['comment']}</span></a></li>
                                                                   <div style='height: 20px; overflow: hidden; width: 100%;''></div>";
                                                               }
                                                               ?>
                                                        </ul>

                                    <hr style="clear:both;visibility:hidden;width:100%;">
                                    <div><div class="wsite-form-field" style="margin:5px 0px 5px 0px;">
                                        <label class="wsite-form-label" for="description">Post to wall: <span class="form-required">*</span></label>
                                        <div class="wsite-form-input-container">
                                            <textarea id="description" class="wsite-form-input wsite-input" name="description" style="width:285px; height: 50px"></textarea>
                                        </div>
                                        <div id="instructions-740288841696996782" class="wsite-form-instructions" style="display:none;"></div>
                                    </div></div>
                                    <div style="text-align:left; margin-top:10px; margin-bottom:10px;">
                                        <input type='submit' name="submit" value="Submit" class='btn btn-eventPR' />
                                    </div>
                                </div>


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