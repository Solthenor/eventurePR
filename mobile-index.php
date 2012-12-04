<?php            //connects to the DB & checks if user is logged in.. This web page is the main index of the mobile site
require_once('db.php');
require_once('checkAuth.php');

if (isset($_POST['mloggedOut'])) {
    setcookie('loggedin', false);
    $id = 0;
}

if (isset($_POST['eventSearch'])) {
    $userName = $_POST['eventSearch'];

    $db = db::getInstance();
    $sql = "SELECT
        eventID
    FROM Event
    WHERE eventName = '{$_POST['eventSearch']}' ; ";

    $stmt = $db->prepare($sql);
    $stmt->execute();
    $event = $stmt->fetch(PDO::FETCH_OBJ);

   header("Location: mobile-event.php?eventID=.$event" ) ;

}
?>

<!DOCTYPE html>
<html> 
	<head>
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

        <title>Welcome to E-vents</title>
	<link rel="stylesheet" href="css/mobile-style.css" />
	<link rel="stylesheet" href="css/jquery.mobile-1.2.0.css" />
    <link href='http://cdn1.editmysite.com/editor/fonts/Capture_it/font.css?2' rel='stylesheet' type='text/css' />
    <link rel='stylesheet' href='http://cdn1.editmysite.com/editor/images/common/common-v2.css?buildTime=1346362758' type='text/css' />


        <script src="js/jquery-1.8.2.js"></script>
	<script src="js/jquery.mobile-1.2.0.js"></script>



        <script>
            $(document).ready(function(){
                $('#select-choice-1').change(function()  {
                    if($(this).children('option:selected').attr('value') != 'mobile-index')  {
                    var $vn = "mobile-events.php?category="+ $(this).children('option:selected').attr('value');
                        window.location.href = $vn;
                    }
                    else {
                        var $vn = $(this).children('option:selected').attr('value') + ".php" ;
                        window.location.href = $vn;
                    }
                });
            });


        </script>

</head> 
<body>

	<div id="wrapper" style="height: 100%">
        <div id="header" >
            <span class='wsite-logo'><a href='mobile-index.php'><span id="wsite-title">EventurePR</span></a></span>
            <div data-role="controlgroup" data-type="horizontal" style="float:left; width: 100%" >
                <?php if($loggedin) { ?>
                <a  href="mobile-profile.php" rel="external" data-role="button" data-theme="c" style="height: 40px; font-size: 15px;"  >Profile</a>
                <form style="float:left;" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST" data-ajax="false">
                        <input  type='submit' name="mloggedOut" id="mloggedOut" value="Log Out" class='btn btn-eventPR' />
                </form>

                <?php }  else {?>
                <p style="font-size: 16px;font-weight: bold;text-shadow: none;">Don't have an account?</p>
                <a  href="mobile-register.php"  rel="external" data-role="button" data-theme="c" style="height: 40px; font-size: 15px;"  >Sign Up</a>
                <a  href="mobile-login.php"  rel="external" data-role="button" data-theme="c" style="height: 40px; font-size: 15px;"  >Log In</a>

                <?php }?>
            </div>
        </div><!-- /header -->
        <div id="content" style=";margin:auto;">
            <div data-role="fieldcontain">
                <label for="select-choice-1" class="select" style="text-shadow: none;">Select an Option:</label>
                <select id="select-choice-1" name="select-choice-1" data-native-menu="true">
                    <option value="">MAIN MENU</option>
                    
                    <option value="Concert">CONCERTS</option>
                    <option value="Sports">SPORTS</option>
                    <option value="Entertainment">ENTERTAINMENT</option>
                    <option value="Business">BUSINESS & EDUCATION</option>
              </select>
            </div> <!--fieldcontain-->

            <!--
            <div id="label" style="margin: auto;">
                <span style="font-size: 18px;color: white; font-weight: bold;text-shadow: none">Find an event: </span>

                <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
                <div data-role="fieldcontain" data-inset="true">
                        <label for="eventSearch" style="font-size: 14px;color: white; padding-top: 5px;">Search:</label>
                        <input style="color: black !important;" type="search" name="eventSearch" id="eventSearch" value=""/>
                    </div> 
                </form>
            </div>
        -->

            <div data-role="fieldcontain" style="margin-top: 10%;">
                <ul data-role="listview" data-inset="true" data-theme="c" data-dividertheme="b">
                    <li data-role="list-divider" style="font-size: 16px;color: white;  ">Featured Events:</li>
                    <li><a href="mobile-event.php?eventID=202"><font size="2">SanSe 2013</font></a></li>
                    <li><a href="mobile-event.php?eventID=203"><font size="2">Calle 13 en PR</font></a></li>
                    <li><a href="mobile-event.php?eventID=204"><font size="2">PR Islanders vs LA Galaxy</font></a></li>


                </ul>
            </div>

            <div data-role="fieldcontain">
                <ul data-role="listview" data-inset="true" data-theme="c" data-dividertheme="b">
                    <li data-role="list-divider" style="font-size: 16px;color: white;margin-top: 10%  ">Other Events:</li>

                    <?php

                                    $db = db::getInstance();
                                    $sql = "SELECT
                                                eventID,
                                                eventName
                                            FROM Event AS r1
                                                JOIN (SELECT (RAND() * (SELECT MAX(eventID) FROM Event)) AS id) AS r2
                                            WHERE r1.eventID >= r2.id
                                            
                                            LIMIT 5
                                    ";

                                    $stmt = $db->prepare($sql);
                                    $stmt->execute();

                                    $result = $stmt->fetchAll();

                                    foreach ($result as &$venue) {
                     echo "<li><a href='mobile-event.php?eventID={$venue['eventID']}'><font size='2' >{$venue['eventName']}</font></a></li>";
                    }
                    ?>
                </ul>
            </div>

<div data-role="controlgroup" data-type="horizontal" style="text-align: center; width: 100%">
        <a href="index.php" rel="external" data-role="button" data-theme="c" style="height: 40px; font-size: 15px;">Click Here For Desktop Version</a>
    </div>
            </div> <!--content-->
    </div>         <!--wrapper-->

</body>
</html>
