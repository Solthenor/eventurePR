<?php
require_once('db.php');
require_once('mobileRedirect.php');
require_once('logoutHandler.php');
require_once('checkAuth.php');

$userID = $_GET['userID'];

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
            userName,
            firstName,
            lastName,
            email,
            profilePicture,
            age,
            gender,
            work
        FROM AddFriend, User
        WHERE userID1 = {$id};
        AND userID2 = 'userID';
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
            <td id="logo"><span class='wsite-logo'><a href='/'><span id="wsite-title">E-venturePR</span></a></span></td>
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

            <div class="text"><div id='wsite-content' class='wsite-not-footer'>

                <h2 style="text-align:left;">Search for friends:<br /></h2>

                <div>
                    <form enctype="multipart/form-data" action="http://www.weebly.com/weebly/apps/formSubmit.php" method="POST" id="form-679517611896646411">
                        <div id="679517611896646411-form-parent" class="wsite-form-container" style="margin-top:10px;">
                            <ul class="formlist" id="679517611896646411-form-list">
                                <div><div class="wsite-form-field" style="margin:5px 0px 5px 0px;">
                                    <label class="wsite-form-label" for="input-678591696370903029">Search name: <span class="form-not-required">*</span></label>
                                    <div class="wsite-form-input-container">
                                        <input id="input-678591696370903029" class="wsite-form-input wsite-input" type="text" name="search" style="width:370px;" />
                                    </div>
                                    <div id="instructions-678591696370903029" class="wsite-form-instructions" style="display:none;"></div>
                                </div></div>
                            </ul>
                        </div>
                        <div style="display:none; visibility:hidden;">
                            <input type="text" name="wsite_subject" />
                        </div>
                        <div style="text-align:left; margin-top:10px; margin-bottom:10px;">
                            <input type="hidden" name="form_version" value="2" />
                            <input type="hidden" name="wsite_approved" id="wsite-approved" value="approved" />
                            <input type="hidden" name="ucfid" value="679517611896646411" />
                            <input type='submit' style='position:absolute;top:0;left:-9999px;width:1px;height:1px' /><a class='wsite-button' onclick="document.getElementById('form-679517611896646411').submit()"><span class='wsite-button-inner'>Submit</span></a>
                        </div>
                    </form>


                </div>


                 <div><div class="wsite-multicol"><div class='wsite-multicol-table-wrap' style='margin:0 -15px'>
                    <table class='wsite-multicol-table'>
                        <tbody class='wsite-multicol-tbody'>
                        <tr class='wsite-multicol-tr'>
                            <td class='wsite-multicol-col' style='width:50%;padding:0 15px'>
                                 <div id="mainmenu">
                                    <ul style="font-size: 22px; color: white;">
                                    <?php

                                    foreach ($result as $contact) { ?>
                                            <div><div style="height: 20px; overflow: hidden; width: 100%;"></div>
                                            <hr class="styled-hr" style="width:100%;"></hr>
                                            <div style="height: 20px; overflow: hidden; width: 100%;"></div></div>

                                        <h2 style="text-align:left;">{$user['userName']}<br /></h2>
                                        <div class="paragraph" style="text-align:left;display:block;float: left;">{$user['firstName']} {$user['lastName']}<br /></div>
                                        <hr style="clear:both;visibility:hidden;width:100%;"></hr>

                                        <div style="text-align:left;"><div style="height: 10px; overflow: hidden;"></div>
                                            <a class="wsite-button wsite-button-small wsite-button-normal" href='profile.php' >
                                                <span class="wsite-button-inner">See profile</span>
                                            </a>
                                            <div style="height: 10px; overflow: hidden;"></div></div>

                                        <div><div style="height: 20px; overflow: hidden; width: 100%;"></div>
                                            <hr class="styled-hr" style="width:100%;"></hr>
                                            <div style="height: 20px; overflow: hidden; width: 100%;"></div></div>";
                                    }


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
    </div>
    <div id="footer"></div>
    <div class="clear"></div>
</div>

</body>
</html>