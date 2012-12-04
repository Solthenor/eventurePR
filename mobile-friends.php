<?php        //loads the events pending on category

require_once('db.php');
require_once('checkAuth.php');



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
        WHERE U.userID in (SELECT
                            F.userID2
                         FROM AddFriend F
                         WHERE F.userID1 = {$id});
";

    $stmt = $db->prepare($sql);
    $stmt->execute();

    $result = $stmt->fetchAll();

?>

<!DOCTYPE html>
<html>
<head>
    <meta content="width=device-width, minimum-scale=1, maximum-scale=1" name="viewport">

    <title>Welcome to E-vents</title>
    <link rel="stylesheet" href="css/mobile-style.css" />
    <link rel="stylesheet" href="css/jquery.mobile-1.2.0.css" />
    <link href='http://cdn1.editmysite.com/editor/fonts/Capture_it/font.css?2' rel='stylesheet' type='text/css' />
    <link rel='stylesheet' href='http://cdn1.editmysite.com/editor/images/common/common-v2.css?buildTime=1346362758' type='text/css' />

    <script src="js/jquery-1.8.2.js"></script>
    <script src="js/jquery.mobile-1.2.0.js"></script>

    <script type='text/javascript' src='https://ajax.googleapis.com/ajax/libs/jquery/1.8.1/jquery.min.js'></script>
    <script type='text/javascript' src='http://cdn1.editmysite.com/editor/libraries/jquery_effects.js?1346362758'></script>
    <script type='text/javascript' src='http://cdn1.editmysite.com/editor/libraries/fancybox/fancybox.min.js?1346362758'></script>
    <script type='text/javascript' src='http://cdn1.editmysite.com/editor/images/common/utilities-jq.js?1346362758'></script>
    <script type='text/javascript' src='http://cdn1.editmysite.com/editor/libraries/flyout_menus_jq.js?1346362758'></script>

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
    <div id="header" style="height: 25%">
        <span class='wsite-logo'><a href="mobile-index.php"><span id="wsite-title" >EventurePR</span></a></span>
        <div data-role="controlgroup" data-type="horizontal" style="float:left;" >
            <?php if($loggedin) { ?>
            <a  href="mobile-profile.php" rel="external" data-role="button" data-theme="c" style="height: 35px; font-size: 15px;"  >Profile</a>
            <a  href="mobile-index.php" rel="external" data-role="button" data-theme="c" style="height: 35px; font-size: 15px;" >Log Out</a>


            <?php }  else {?>
            <p style="font-size: 16px;font-weight: bold;text-shadow: none;">Don't have an account?</p>
            <a  href="mobile-register.php"  rel="external" data-role="button" data-theme="c" style="height: 35px; font-size: 15px;"  >Sign up</a>
            <a  href="mobile-login.php"  rel="external" data-role="button" data-theme="c" style="height: 35px; font-size: 15px;"  >Log in</a>

            <?php }?>
        </div>
    </div><!-- /header -->
    <div id="content" style="height: 75%; padding-top: 50px;">

        
        
        <h1 style="color:white; text-shadow: none; text-align: left; clear:left;">Friends List: </h1>

        <?php

                    foreach ($result as $friend) {

                        ?>
        <div id="list">
            <ul data-role="listview" data-inset="true" data-split-theme="c">
                <li><a href=""><img src="picture.php?picID=<?php echo $friend['profilePicture'] ?>" class="ui-li-thumb" style="position:absolute !important; top: 10px; left: 10px; height: 80%"><h3><?php echo $friend['firstName'] ?> <?php echo $friend['lastName'] ?></h3></a></li>
            </ul>

        </div>
                        <?php

                    }

        ?>
        <div data-role="controlgroup" data-type="horizontal" style="text-align: center; width: 100%">
        <a href="mobile-profile.php" rel="external" data-role="button" data-theme="c" style="height: 40px; font-size: 15px;">Back to Profile</a>
        </div>
        <div data-role="controlgroup" data-type="horizontal" style="text-align: center; width: 100%">
        <a href="mobile-index.php" rel="external" data-role="button" data-theme="c" style="height: 40px; font-size: 15px;">Back Home</a>
        </div>
    </div>
</div>         <!--wrapper-->






</body>
</html>
