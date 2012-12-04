<?php
    require_once('mobileRedirect.php');
    require_once('db.php');
    require_once('checkAuth.php');
    require_once('logoutHandler.php');

    $eventID= $_GET['eventID'];
    $userID = $_GET['userID'];

// Checks if user is logged in, otherwise returns index
    if (!$loggedin && !isset($userID)) {
        header('Location: index.php');
        return;
    }

    if(isset($userID)) {
        $id = $userID;
    }

    if (!isset($eventID)) {
    header('Location: index.php');
    return;
    }

$db = db::getInstance();
$sql = "SELECT
            E.eventID,
            E.eventName
        FROM EVENT E
        WHERE E.eventID = {$eventID};
";

$stmt = $db->prepare($sql);
$stmt->execute();

$result = $stmt->fetchAll();

$event = $result[0];

    $db = db::getInstance();
    $sql = "SELECT
            userName,
            firstName,
            lastName,
            email
        FROM User
        WHERE userID = {$id};
";

    $stmt = $db->prepare($sql);
    $stmt->execute();

    $result = $stmt->fetchAll();

    $user = $result[0];

if ( count($_POST) > 0) {

    $to = $_POST['email'];
    $subject = $event['eventName'];
    $body = $_POST['message'];
    $headers = "From:" . "{$user['email']}" . "\n";

    if(mail($to,$subject,$body,$headers)) {
        echo "An e-mail was sent to $to with the subject: $subject";
    } else {
        echo "There was a problem sending the mail. Check your code and make sure that the e-mail address $to is valid";
    }
?>

    <!DOCTYPE html>
<html>
<head>
    <title>Contacts - E-venturePR</title>


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
        #wsite-content a:link, .blog-sidebar a:link{color:#FFFFFF !important;}
        #wsite-content a:visited, .blog-sidebar a:visited{color:#FFFFFF !important;}
        #wsite-content a:hover, .blog-sidebar a:hover{color:#FFFFFF !important;}
    </style>
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
    <script type='text/javascript'><!--
    var IS_ARCHIVE=1;
    (function(jQuery){
        function initFlyouts(){initPublishedFlyoutMenus([{"id":"581818271480209023","title":"Home","url":"index.php"},{"id":"145650631833651339","title":"Concerts","url":"events.php?category=Concert"},{"id":"404778243583026952","title":"Sports","url":"events.php?category=Sports"},{"id":"441792526610757515","title":"Entertainment","url":"events.php?category=Entertainment"},{"id":"269210016325162137","title":"Business & Education","url":"events.php?category=Business"},{"id":"224132398954985812","title":"About us","url":"about.php"}],'435700788219059228',"<li class='wsite-nav-more'><a href='#'>more...<\/a><\/li>",'active',false)}
        if (jQuery) {
            if (jQuery.browser.msie) window.onload = initFlyouts;
            else jQuery(initFlyouts)
        }else{
            if (Prototype.Browser.IE) window.onload = initFlyouts;
            else document.observe('dom:loaded', initFlyouts);
        }
    })(window._W && _W.jQuery)
    //-->
    </script>
</head>
<body class='wsite-theme-dark no-header-page wsite-page-add-friends'>
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
            <div class="text"><div id='wsite-content' class='wsite-not-footer'>
                <div><div style="height: 20px; overflow: hidden; width: 100%;"></div>
                    <hr class="styled-hr" style="width:100%;"></hr>
                    <div style="height: 20px; overflow: hidden; width: 100%;"></div></div>

                <h2 style="text-align:left;">Share E-venture<br /></h2>

                <div><div class="wsite-form-field" style="margin:5px 0px 5px 0px;">
                    <label class="wsite-form-label" for="email">Email to send to: <span class="form-required">*</span></label>
                    <div class="wsite-form-input-container">
                        <input id="email" class="wsite-form-input wsite-input" type="text" name="email" style="width:200px;" />
                    </div>
                    <div id="instructions-461209313855761342" class="wsite-form-instructions" style="display:none;"></div>
                </div></div>

                <div><div class="wsite-form-field" style="margin:5px 0px 5px 0px;">
                    <label class="wsite-form-label" for="email">Message: <span class="form-required">*</span></label>
                    <div class="wsite-form-input-container">
                        <textarea name="message"> </textarea>
                    </div>
                    <div id="instructions-461209313855761342" class="wsite-form-instructions" style="display:none;"></div>
                </div></div>
                <div style="text-align:left; margin-top:10px; margin-bottom:10px;">
                    <input type='submit' name="submit" value="Submit" class='btn btn-eventPR' />
                </div>

                <div><div style="height: 20px; overflow: hidden; width: 100%;"></div>
                    <hr class="styled-hr" style="width:100%;" />
                    <div style="height: 20px; overflow: hidden; width: 100%;"></div></div>


            </div>
            </div>
        </div>

    </div>

</body>
</html>