<?php                    //adds contacts to the users friends  Database... Looks up users by user Name.
require_once('db.php');
require_once('checkAuth.php');
if (isset($_POST['friendSearch'])) {
    $userName = $_POST['friendSearch'];

    $db = db::getInstance();
    $sql = "SELECT
        userName
    FROM User
    WHERE userName = '{$userName}'; ";

    $stmt = $db->prepare($sql);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_OBJ);

    if(!empty($user)){
        $userID2 = $user->userName;
    }

}


if(isset($_POST['submit']))
{
    $db = db::getInstance();

    $sql = "INSERT INTO AddFriend
                SET
                    userID1 = {$id},
                    userID2 = {$userName}
                    ;";

    $stmt = $db->prepare($sql);
    $stmt->execute();

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
        <span class='wsite-logo'><span id="wsite-title" >EventurePR</span></span>
        <div data-role="controlgroup" data-type="horizontal" style="float:left;" >
            <?php if($loggedin) { ?>
            <a  href="mobile-profile.php" rel="external" data-role="button" data-theme="c" style="height: 35px; font-size: 15px;"  >Profile</a>
            <a  href="mobile-index.php" rel="external" data-role="button" data-theme="c" style="height: 35px; font-size: 15px;" >Log out</a>


            <?php }  else {?>
            <p style="font-size: 16px;font-weight: bold;text-shadow: none;">Dont have an account?</p>
            <a  href="mobile-register.php"  rel="external" data-role="button" data-theme="c" style="height: 35px; font-size: 15px;"  >Sign up</a>
            <a  href="mobile-login.php"  rel="external" data-role="button" data-theme="c" style="height: 35px; font-size: 15px;"  >Log in</a>

            <?php }?>
        </div>
    </div><!-- /header -->
    <div id="content" style=";margin:auto;">
        <div data-role="fieldcontain">
            <label for="select-choice-1" class="select" style="text-shadow: none;">Select an Option:</label>
            <select id="select-choice-1" name="select-choice-1" data-native-menu="true">
                <option value="">MAIN MENU</option>
                <option value="mobile-index">HOME</option>
                <option value="Concert">CONCERTS</option>
                <option value="Sports">SPORTS</option>
                <option value="Entertainment">ENTERTAINMENT</option>
                <option value="Business">BUSINESS & EDUCATION</option>
            </select>
        </div> <!--fieldcontain-->

        <div id="label" style="margin: auto;">
            <span style="font-size: 18px;color: white; font-weight: bold;text-shadow: none">Search for friends: </span>

            <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
                <div data-role="fieldcontain" data-inset="true">
                    <label for="friendSearch" style="font-size: 14px;color: white; padding-top: 5px;">Search:</label>
                    <input style="color: black !important;" type="search" name="friendSearch" id="friendSearch" value=""/>
                </div> 
            </form>
        </div> 
        <?php


        if(isset($userID2)) {?>
            </br>
            Friend found!!</br>
            <div id="list">
                <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">

                <input  type='submit' name="submit" value="<?php echo $userID2 ?> :  Click Here to add friend!" class='btn btn-eventPR' />
                </form>

            </div>
            <?php }?>




    </div> <!--content-->
</div>         <!--wrapper-->

</body>
</html>

