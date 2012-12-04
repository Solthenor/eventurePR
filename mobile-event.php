<?php            //connects to the DB & checks if user is logged in.. This web page is the main index of the mobile site
require_once('db.php');
require_once('checkAuth.php');

if (isset($_POST['mloggedOut'])) {
    setcookie('loggedin', false);
    $id = 0;
}

$eventID = $_GET['eventID'];

if (!isset($eventID)) {
    header('Location: index.php');
    return;
}

$db = db::getInstance();
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
            V.venueID,
            V.vName as venueName,
            U.userName,
            (SELECT
                COUNT(*)
            FROM Attends A
            WHERE A.eventID = E.eventID) AS attendees
        FROM Event E
            INNER JOIN Venue V
                 ON E.venueID = V.venueID
            INNER JOIN User U
                 ON U.userID = E.userID
        WHERE E.eventID = {$eventID};
";

$stmt = $db->prepare($sql);
$stmt->execute();

$result = $stmt->fetchAll();

$event = $result[0];
$attendees = $event['attendees'];

if(!isset($event)){
    header('Location: index.php');
    return;
}

if(isset($_POST['action'])) {

    $action = $_POST['action'];

    $db = db::getInstance();

    $sql = "";

    if($action == 'flag'){
        $sql = "UPDATE Event
                SET
                    flag = 1
                WHERE eventID = {$eventID};";
    }
    else if($action == 'I want to go!!!'){
        $sql = "INSERT INTO Attends
                SET
                    userID = {$id},
                    eventID = {$eventID};";
    }

    $stmt = $db->prepare($sql);
    $stmt->execute();

    $attendees = $event['attendees'];
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
                <input  type='submit' name="mloggedOut" id="mloggedOut" value="Log out" class='btn btn-eventPR' />
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
                <option value="mobile-index">HOME</option>
                <option value="Concert">CONCERTS</option>
                <option value="Sports">SPORTS</option>
                <option value="Entertainment">ENTERTAINMENT</option>
                <option value="Business">BUSINESS & EDUCATION</option>
            </select>
        </div> 

        <div id="label" style="margin: auto;padding-top:20px;">

            <span style="position:relative;">
                <a href="mobile-event.php?eventID=<?php echo $event['eventID'] ?>">
                    <img src="picture.php?picID=<?php echo $event['flyer'] ?>" class=" galleryImageBorder" style="width:100%;" >
                </a>
            </span>
            <br>
            <br>

            <span style="position:relative; font-size: 22px;color: white; font-weight: bold;text-shadow: none">Event Name:</span>  <span style="font-size: 18px;font-weight: bold;text-shadow: none; color: #32CD32; text-decoration: underline;"><?php echo $event['eventName'] ?></span>
            <br>
            <br>
            <span style="position:relative; font-size: 22px;color: white; font-weight: bold;text-shadow: none">Date:</span>  <span style="font-size: 18px;font-weight: bold;text-shadow: none; color: #32CD32; text-decoration: underline;"><?php echo $event['date'] ?></span>
            <br>
            <br>
            <span style="position:relative; font-size: 22px;color: white; font-weight: bold;text-shadow: none">Start Time:</span>  <span style="font-size: 18px;font-weight: bold;text-shadow: none; color: #32CD32; text-decoration: underline;"><?php echo $event['startHour'] ?></span>
            <br>
            <br>
            <span style="position:relative; font-size: 22px;color: white; font-weight: bold;text-shadow: none">End Time:</span>  <span style="font-size: 18px;font-weight: bold;text-shadow: none; color: #32CD32; text-decoration: underline;"><?php echo $event['endHour'] ?></span>
            <br>
            <br>
            <span style="position:relative; font-size: 22px;color: white; font-weight: bold;text-shadow: none">Location:</span>  <span style="font-size: 18px;font-weight: bold;text-shadow: none; color: #32CD32 !important; text-decoration: underline;"><?php echo $event['venueName'] ?></span>
            <br>
            <br>
            <span style="position:relative; font-size: 22px;color: white; font-weight: bold;text-shadow: none">Type:</span>  <span style="font-size: 18px;font-weight: bold;text-shadow: none; color: #32CD32; text-decoration: underline;"><?php echo $event['eventType'] ?></span>
            <br>
            <br>
            <span style="position:relative; font-size: 22px;color: white; font-weight: bold;text-shadow: none">Genre:</span>  <span style="font-size: 18px;font-weight: bold;text-shadow: none; color: #32CD32; text-decoration: underline;"><?php echo $event['genre'] ?></span>
            <br>
            <br>
            <span style="position:relative; font-size: 22px;color: white; font-weight: bold;text-shadow: none">Entrance Fee:</span>  <span style="font-size: 18px;font-weight: bold;text-shadow: none; color: #32CD32; text-decoration: underline;"><?php echo $event['price'] ?></span>
            <br>


        </div>
        <div id="description">
            <br>
        <span style="font-size: 22px;color: white; font-weight: bold;text-shadow: none">Description:<br></span>  <span style="font-size: 18px;font-weight: bold;text-shadow: none; color: white;"><?php echo $event['description'] ?>
</span>
        </div>




    </div> <!--content-->
</div>         <!--wrapper-->

</body>
</html>
