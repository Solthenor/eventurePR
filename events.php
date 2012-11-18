<?php      // Displays the events category browser. Depending on which category the user chooses, the information is displayed for him accordingly.
require_once('mobileRedirect.php');
require_once('logoutHandler.php');
require_once('db.php');
require_once('checkAuth.php');

$category = $_GET['category'];
$subCategory = $_GET['subcategory'];

if (!isset($category)) {
    header('Location: index.php');
    return;
}

$db = db::getInstance();
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
            E.eventID,
            V.vName as venueName
        FROM Event E
            INNER JOIN Venue V
                 ON E.venueID = V.venueID
        WHERE E.eventType = '{$category}'
";

if (isset($subCategory)) {
    $sql .= " AND E.genre = '{$subCategory}';" ;
}

$stmt = $db->prepare($sql);
$stmt->execute();

$events = $stmt->fetchAll();

?>
<!DOCTYPE html>
<html>
<head>
    <title>Concerts - E-venturePR</title>

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
    </style>
    <style type='text/css'>
        .wsite-header {
            <?php if($category == 'Business') { ?>
            background-image: url(uploads/1/3/4/4/13443306/header_images/1346209457.jpg) !important; 
            <?php } ?>
            <?php if($category == 'Entertainment') { ?>
            background-image: url(uploads/1/3/4/4/13443306/header_images/1346209272.jpg) !important;
            <?php } ?>
            <?php if($category == 'Sports') { ?>
            background-image: url(uploads/1/3/4/4/13443306/header_images/1346208915.jpg) !important;
            <?php } ?>
            <?php if($category == 'Concert') { ?>
            background-image: url(uploads/1/3/4/4/13443306/header_images/1346208841.jpg) !important;
            <?php } ?>
            background-position: 0 0 !important;
        }
    </style>
    <script type='text/javascript' src='https://ajax.googleapis.com/ajax/libs/jquery/1.8.1/jquery.min.js'></script>
    <script type='text/javascript' src='http://cdn1.editmysite.com/editor/libraries/jquery_effects.js?1346362758'></script>
    <script type='text/javascript' src='http://cdn1.editmysite.com/editor/libraries/fancybox/fancybox.min.js?1346362758'></script>
    <script type='text/javascript' src='http://cdn1.editmysite.com/editor/images/common/utilities-jq.js?1346362758'></script>
    <script type='text/javascript' src='http://cdn1.editmysite.com/editor/libraries/flyout_menus_jq.js?1346362758'></script>
    <script src="js/bootstrap.min.js"></script>
</head>
<body class='wsite-theme-dark tall-header-page wsite-page-concerts'>
<div id="wrapper">
    <table id="header">
        <tr>
            <td id="logo"><span class='wsite-logo'><a href='/'><span id="wsite-title">E-venturePR</span></a></span></td>
            <td id="header-right">
                <table>
                    <?php if($loggedin) { ?>
                        <tr>
                            <td class="phone-number"><span class='wsite-text'><a href="profile.php" style="color: #32CD32; text-decoration: underline; ">Profile</a> | 
                                    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST"> 
                                        <input type="hidden" value="logout" name="loggedOut" />
                                        <input type="submit" style="color: #32CD32; text-decoration: underline;" value="Log out" />
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
        <div id="container" style="margin-top: 29px;">
            <div id="content">
                <div id="banner">
                    <div class="wsite-header"></div>
                </div>
                <div class="text"><div id='wsite-content' class='wsite-not-footer'>
                    <div>

                        <div class="btn-toolbar" style="text-align: center">
                            <div class="btn-group">
                                <?php if($category == 'Concert') { ?>
                                <a class="btn btn-eventPR" href="events.php?category=Concert"><span style="font-weight: bold; font-size: 14px; font-family: arial sans-serif;"> SHOW ALL</span></a>
                                <a class="btn btn-eventPR" href="events.php?category=Concert&subcategory=Alternative"><span style="font-weight: bold; font-size: 14px; font-family: arial sans-serif;">ALTERNATIVE</span></a>
                                <a class="btn btn-eventPR" href="events.php?category=Concert&subcategory=Rock"><span style="font-weight: bold; font-size: 14px; font-family: arial sans-serif;"> ROCK</span></a>
                                <a class="btn btn-eventPR" href="events.php?category=Concert&subcategory=Pop"><span style="font-weight: bold; font-size: 14px; font-family: arial sans-serif;">POP</span></a>
                                <a class="btn btn-eventPR" href="events.php?category=Concert&subcategory=Rap"><span style="font-weight: bold; font-size: 14px; font-family: arial sans-serif;"> HIP HOP/RAP</span></a>
                                <a class="btn btn-eventPR" href="events.php?category=Concert&subcategory=Electronic"><span style="font-weight: bold; font-size: 14px; font-family: arial sans-serif;"> ELECTRONIC</span></a>
                                <a class="btn btn-eventPR" href="events.php?category=Concert&subcategory=Country"><span style="font-weight: bold; font-size: 14px; font-family: arial sans-serif;">COUNTRY</span></a>
                                <a class="btn btn-eventPR" href="events.php?category=Concert&subcategory=Classical"><span style="font-weight: bold; font-size: 14px; font-family: arial sans-serif;">CLASSICAL</span></a>
                                <?php } ?>
                                <?php if($category == 'Business') { ?>
                                <a class="btn btn-eventPR" href="events.php?category=Business"><span style="font-weight: bold; font-size: 14px; font-family: arial sans-serif;">SHOW ALL</span></a>
                                <a class="btn btn-eventPR" href="events.php?category=Business&subcategory=Conferences"><span style="font-weight: bold; font-size: 14px; font-family: arial sans-serif;">CONFERENCES</span></a>
                                <a class="btn btn-eventPR" href="events.php?category=Business&subcategory=Meetings"><span style="font-weight: bold; font-size: 14px; font-family: arial sans-serif;">BUSINESS MEETINGS</span></a>
                                <a class="btn btn-eventPR" href="events.php?category=Business&subcategory=Seminars"><span style="font-weight: bold; font-size: 14px; font-family: arial sans-serif;">SEMINARS</span></a>
                                <a class="btn btn-eventPR" href="events.php?category=Business&subcategory=Sales"><span style="font-weight: bold; font-size: 14px; font-family: arial sans-serif;">SALES & AUCTIONS</span></a>
                                <a class="btn btn-eventPR" href="events.php?category=Business&subcategory=JobFairs"><span style="font-weight: bold; font-size: 14px; font-family: arial sans-serif;">JOB FAIRS</span></a>
                                <?php } ?>
                                <?php if($category == 'Entertainment') { ?>
                                <a class="btn btn-eventPR" href="events.php?category=Entertainment"><span style="font-weight: bold; font-size: 14px; font-family: arial sans-serif;">SHOW ALL</span></a>
                                <a class="btn btn-eventPR" href="events.php?category=Entertainment&subcategory=Culinary"><span style="font-weight: bold; font-size: 14px; font-family: arial sans-serif;">CULINARY</span></a>
                                <a class="btn btn-eventPR" href="events.php?category=Entertainment&subcategory=Cinema"><span style="font-weight: bold; font-size: 14px; font-family: arial sans-serif;">CINEMA</span></a>
                                <a class="btn btn-eventPR" href="events.php?category=Entertainment&subcategory=Arts"><span style="font-weight: bold; font-size: 14px; font-family: arial sans-serif;">ARTS & CRAFT</span></a>
                                <a class="btn btn-eventPR" href="events.php?category=Entertainment&subcategory=Theater"><span style="font-weight: bold; font-size: 14px; font-family: arial sans-serif;">THEATER</span></a>
                                <a class="btn btn-eventPR" href="events.php?category=Entertainment&subcategory=Comedy"><span style="font-weight: bold; font-size: 14px; font-family: arial sans-serif;">COMEDY</span></a>
                                <a class="btn btn-eventPR" href="events.php?category=Entertainment&subcategory=Politics"><span style="font-weight: bold; font-size: 14px; font-family: arial sans-serif;">POLITICS</span></a>
                                <?php } ?>
                                <?php if($category == 'Sports') { ?>
                                <a class="btn btn-eventPR" href="events.php?category=Sports"><span style="font-weight: bold; font-size: 14px; font-family: arial sans-serif;">SHOW ALL</span></a>
                                <a class="btn btn-eventPR" href="events.php?category=Sports&subcategory=Basketball"><span style="font-weight: bold; font-size: 14px; font-family: arial sans-serif;">BASKETBALL</span></a>
                                <a class="btn btn-eventPR" href="events.php?category=Sports&subcategory=Baseball"><span style="font-weight: bold; font-size: 14px; font-family: arial sans-serif;">BASEBALL</span></a>
                                <a class="btn btn-eventPR" href="events.php?category=Sports&subcategory=Soccer"><span style="font-weight: bold; font-size: 14px; font-family: arial sans-serif;">SOCCER</span></a>
                                <a class="btn btn-eventPR" href="events.php?category=Sports&subcategory=Volleyball"><span style="font-weight: bold; font-size: 14px; font-family: arial sans-serif;">VOLLEYBALL</span></a>
                                <a class="btn btn-eventPR" href="events.php?category=Sports&subcategory=Boxing"><span style="font-weight: bold; font-size: 14px; font-family: arial sans-serif;">BOXING</span></a>
                                <a class="btn btn-eventPR" href="events.php?category=Sports&subcategory=Cycling"><span style="font-weight: bold; font-size: 14px; font-family: arial sans-serif;">OTHER</span></a>
                                <?php } ?>
                            </div>
                        </div></div>
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
                                <td class='wsite-multicol-col' style='width:79.074889867841%;padding:0 15px'>

                                    <h2 style="text-align:left;"><?php echo $event['eventName'] ?></h2>
                                    <span class='imgPusher' style='float:left;height:0px'></span><span style='position:relative;float:left;z-index:10;;clear:left;margin-top:0px;*margin-top:0px'><a><img class="wsite-image galleryImageBorder" src="picture.php?picID=<?php echo $event['flyer'] ?>" style="margin-top: 5px; margin-bottom: 10px; margin-left: 0px; margin-right: 10px; border-width:1px;padding:3px;" alt="Picture" /></a><div style="display: block; font-size: 90%; margin-top: -10px; margin-bottom: 10px; text-align: center;"></div></span>
                                    <div class="paragraph" style="text-align:left;display:block;"><font size="4"><?php echo $event['date'] ?></font><br /><font size="4"><?php echo $event['venueName'] ?></font><br /><font size="4"><span style="line-height: 27px;"><br /></span></font><br /><font size="4"><span style="line-height: 27px;">Genre: <?php echo $event['genre'] ?></span></font></div>
                                    <hr style="clear:both;visibility:hidden;width:100%;">

                                    <div style="display: inline;"><div style="float:left; display: inline-block;"> </div>
                                        <a class="btn btn-eventPR" href="event.php?eventID=<?php echo $event['eventID'] ?>"><span style="font-weight: bold; font-size: 14px; font-family: arial sans-serif;">MORE INFO</span></a>
                                        <a class="btn btn-eventPR" href="#"><span style="font-weight: bold; font-size: 14px; font-family: arial sans-serif;">FLAG</span></a>
                                        <div style="height: 10px; overflow: hidden;"></div></div>

                                </td>
                                <td class='wsite-multicol-col' style='width:20.925110132159%;padding:0 15px'>

                                    <div style="text-align:left;"><div style="height: 10px; overflow: hidden;"></div>
                                        <a class="wsite-button wsite-button-small wsite-button-highlight" href="javascript:;" >
                                            <span class="wsite-button-inner">Find tickets</span>
                                        </a>
                                        <div style="height: 10px; overflow: hidden;"></div></div>

                                    <div style="text-align:left;"><div style="height: 10px; overflow: hidden;"></div>
                                        <a class="wsite-button wsite-button-small wsite-button-highlight" href="share.html" >
                                            <span class="wsite-button-inner">Share E-venture</span>
                                        </a>
                                        <div style="height: 10px; overflow: hidden;"></div></div>

                                    <div style="text-align:left;"><div style="height: 10px; overflow: hidden;"></div>
                                        <a class="wsite-button wsite-button-small wsite-button-highlight" href="javascript:;" >
                                            <span class="wsite-button-inner">set calendar</span>
                                        </a>
                                        <div style="height: 10px; overflow: hidden;"></div></div>

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
        </div>
        <div id="footer"></div>
        <div class="clear"></div>
    </div>

</body>
</html>