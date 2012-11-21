<!-- 
Welcoming page for EventurePR
     

-->

<?php
require_once('mobileRedirect.php');
require_once('logoutHandler.php');
require_once('db.php');
require_once('checkAuth.php');

?>
<!DOCTYPE html>
<html>

<head>
    <title>E-venturePR - Home</title>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

    <link rel='stylesheet' type='text/css' href='http://cdn1.editmysite.com/editor/libraries/fancybox/fancybox.css?1346362758'>
    <link rel='stylesheet' href='http://cdn1.editmysite.com/editor/images/common/common-v2.css?buildTime=1346362758' type='text/css' />
    <link rel='stylesheet' type='text/css' href='css/main_style.css' title='wsite-theme-css' />
    <link href='http://cdn1.editmysite.com/editor/fonts/Capture_it/font.css?2' rel='stylesheet' type='text/css' />
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/carousel.css" rel="stylesheet">
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
            <td id="logo"><span class='wsite-logo'><a href='/'><span id="wsite-title">E-venturePR</span></a></span></td>
            <td id="header-right">
                <table style="width: 150px;">
                    <!-- Conditional to check login Status-->
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
            <div id="banner" >
                <div class="wsite-header"></div>
            </div>
            <div class="text"><div id='wsite-content' class='wsite-not-footer'>
                <h2 style="text-align:left;"><u>Featured Events:</u></h2>

                <div><div class="wsite-multicol"><div class='wsite-multicol-table-wrap' style='margin:0 -15px'>
                    <table class='wsite-multicol-table'>
                        <tbody class='wsite-multicol-tbody'>
                        <tr class='wsite-multicol-tr'>
                            <td class='wsite-multicol-col' style='width:34.634492266734%;padding:0 15px'>
                                <h2 style="text-align:left;">Entertainment<br /></h2>
                                <span class='imgPusher' style='float:right;height:0px'></span><span style='position:relative;float:right;z-index:10;;clear:right;margin-top:0px;*margin-top:0px'><a href=''><img class="wsite-image galleryImageBorder" src="img/sanse.jpg" style="margin-top: 5px; margin-bottom: 10px; margin-left: 10px; margin-right: 0px; border-width:1px;padding:3px;width:75%;" alt="Picture" /></a><div style="display: block; font-size: 90%; margin-top: -10px; margin-bottom: 10px; text-align: center;"></div></span>
                                <div class="paragraph" style="text-align:left;display:block;"><a href="">"Fiestas San'Se 2013"</a></div>
                                <hr style="clear:both;visibility:hidden;width:100%;">
                            </td>
                            <td class='wsite-multicol-col' style='width:33.840153244709%;padding:0 15px'>
                                <h2 style="text-align:left;">Concerts</h2>
                                <span class='imgPusher' style='float:right;height:0px;'></span><span style='position:relative;float:right;z-index:10;;clear:right;margin-top:0px;*margin-top:0px'><a href="#"><img class="wsite-image galleryImageBorder" src="img/Calle13-150.jpg" style="margin-top: 5px; margin-bottom: 10px; margin-left: 10px; margin-right: 0px; border-width:1px;padding:3px;" alt="Picture" /></a><div style="display: block; font-size: 90%; margin-top: -10px; margin-bottom: 10px; text-align: center;"></div></span>
                                <div class="paragraph" style="text-align:left;display:block;"><a href="#">"Calle 13 en PR"&nbsp;<br /><br /></a></div>
                                <hr style="clear:both;visibility:hidden;width:100%;">
                            </td>
                            <td class='wsite-multicol-col' style='width:31.525354488556%;padding:0 15px'>
                                <h2 style="text-align:left;">Sports</h2>
                                <span class='imgPusher' style='float:right;height:0px'></span><span style='position:relative;float:right;z-index:10;;clear:right;margin-top:0px;*margin-top:0px'><a href=''><img class="wsite-image galleryImageBorder" src="img/estadiojrl.jpg" style="margin-top: 5px; margin-bottom: 10px; margin-left: 10px; margin-right: 0px; border-width:1px;padding:3px;" alt="Picture" /></a><div style="display: block; font-size: 90%; margin-top: -10px; margin-bottom: 10px; text-align: center;"></div></span>
                                <div class="paragraph" style="text-align:left;display:block;"><a href="">"PR Islanders vs LA Galaxy"</a></div>
                                <hr style="clear:both;visibility:hidden;width:100%;">
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div></div></div>

                <div><div style="height: 20px; overflow: hidden; width: 100%;"></div>
                    <hr class="styled-hr" style="width:100%;">
                    <div style="height: 20px; overflow: hidden; width: 100%;"></div></div>

                <h2 style="text-align:left;"><u>Other Events:</u></h2>

               <div><div class="wsite-multicol"><div class='wsite-multicol-table-wrap' style='margin:0 -15px'>
                    <table class='wsite-multicol-table'>
                        <tbody class='wsite-multicol-tbody'>
                        <tr class='wsite-multicol-tr'>
                            <td class='wsite-multicol-col' style='width:50%;padding:0 15px'>
                                 <div id="mainmenu">
                                 	<ul style="font-size: 22px; color: white;">

                                    <!-- Query to randomly select events-->    
                                 	<?php

                                    $db = db::getInstance();
                                    $sql = "SELECT 
                                                eventID,
                                                eventName
                                            FROM Event AS r1 
                                                JOIN (SELECT (RAND() * (SELECT MAX(eventID) FROM Event)) AS id) AS r2
                                            WHERE r1.eventID >= r2.id
                                            ORDER BY r1.eventID ASC
                                            LIMIT 5
                                    ";

                                    $stmt = $db->prepare($sql);
                                    $stmt->execute();
                                    
                                    $result = $stmt->fetchAll();

                                    foreach ($result as &$venue) {
                                      echo "<li><a href='event.php?eventID={$venue['eventID']}'> <span style='color: white'>{$venue['eventName']}</span></a></li>
                                        <hr class='styled-hr' style='width:100%;''>
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
        </div>
    </div>

    <div id="footer">
    <div id="mobileLink" style="text-align: center;position: relative; ">
        <a href="mobile-index.php"><button class="btn btn-eventPR" style="height:60px; font-weight: bold;">Click Here For Mobile Version!</button></a>
    </div>
    </div>
    <div class="clear"></div>
    </div>
</body>
</html>