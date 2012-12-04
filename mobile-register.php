<?php        //This is where the user registers in from his mobile phone fillling his or her account information. This is saved in the database table for Users.

if(isset($_COOKIE['loggedin'])){
    $loggedin = true;
    header('Location: mobile-index.php');
    return;
}

$loggedin = false;
$id = 0;

if ( count($_POST) > 0) {
    require_once('db.php');
    $db = db::getInstance();

    if($_POST['submit'] != 'Login'){


//                age = '{$_POST['age']}',
// gender = '{$_POST['date']}',
// work = '{$_POST['date']}'

        $password = md5 ( $_POST['password'] );

        $sql = "INSERT INTO User
SET
userName = '{$_POST['username']}',
firstName = '{$_POST['first-name']}',
lastName = '{$_POST['last-name']}',
email = '{$_POST['email']}',
password = '{$password}',
age = '{$_POST['age']}',
gender = '{$_POST['gender']}',
work = '{$_POST['work']}',
securityQuestion = '{$_POST['question']}',
securityAnswer = '{$_POST['answer']}'
";

        $stmt = $db->prepare($sql);
// $stmt->bindValue(':vName', , PDO::PARAM_STR);
        $stmt->execute();
        $loggedin = true;
        $id = $db->lastInsertId();

        if ($_FILES["photo"]["error"] == 0) {

            $type = str_replace('image/', '', $_FILES['photo']['type']);

            $fileName = $_FILES['photo']['name'];
            $tmpName  = $_FILES['photo']['tmp_name'];
            $fileSize = $_FILES['photo']['size'];
            $fileType = $_FILES['photo']['type'];

            $fp      = fopen($tmpName, 'r');
            $content = fread($fp, filesize($tmpName));
            $content = addslashes($content);
            fclose($fp);

            $sql = "INSERT INTO Picture
SET
userID = '{$id}',
ext = '{$type}',
data = '{$content}'";

            $stmt = $db->prepare($sql);
            $stmt->execute();

            $picID = $db->lastInsertId();

            $sql = "UPDATE User
SET
profilePicture = '{$picID}'
WHERE userID = '{$id}'";

            $stmt = $db->prepare($sql);
            $stmt->execute();
        }
        else{
// Default photo

        }
    }
    else {
        $password = md5 ( $_POST['password'] );
        $sql = "SELECT
userID,
userName,
password
FROM user
WHERE userName = '{$_POST['username']}'
AND password = '{$password}';
";
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();

        if(count($result) > 0) {
            $loggedin = true;
            $id = $result[0]['userID'];
        }
    }
}

if($loggedin) {
    setcookie('loggedin', $id, time() + (86400 * 7)); // 86400 = 1 day
    header('Location: mobile-index.php');
    return;
}
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/html">
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
                var $vn = $(this).children('option:selected').attr('value') + ".php";

                window.location.href = $vn;
            });
        });


    </script>

</head>
<body>

<div id="wrapper" style="height: 100%">
    <div id="header" style="height: 25%">
        <span class='wsite-logo'><span id="wsite-title" >EventurePR</span></span>
        <div data-role="controlgroup" data-type="horizontal" style="float:left;" >
            <?php if($loggedin) { ?>
            <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST" data-theme="c">
            <a  href="mobile-profile.php" rel="external" data-role="button" data-theme="c" style="height: 35px; font-size: 15px;"  >Profile</a>
            <input value="Logout" rel="external" data-role="button" data-theme="c" style="height: 35px; font-size: 15px;" >Log Out

            </form>
            <?php }  else {?>
            <p style="font-size: 16px;font-weight: bold;text-shadow: none;">Don't have an account?</p>
            <a  href="mobile-register.php"  rel="external" data-role="button" data-theme="c" style="height: 35px; font-size: 15px;"  >Sign Up</a>
            <a  href="mobile-login.php"  rel="external" data-role="button" data-theme="c" style="height: 35px; font-size: 15px;"  >Log In</a>

            <?php }?>
        </div>
    </div><!-- /header -->
    <div id="content" style="height: 75%;">
        <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST" data-theme="c">
            <div data-role="fieldcontain">
                <div style="width: 100%;margin-bottom: 5%;">
                    <label for="email">E-mail: <span class="form-required">*</span></label>
                    <input style="color: black !important;" type="text" name="email" id="email" value="" style="padding-left: 40%; margin-left: 13%"  />
                    <label for="username">User Name: <span class="form-required">*</span></label>
                    <input style="color: black !important;" id="username" type="text" name="username" " />
                    <label for="password">Password:<span class="form-required">*</span></label>
                    <input style="color: black !important;" type="password" name="password" id="password" value=""  />
                    <label for="age">Age:<span class="form-required">*</span></label>
                    <input style="color: black !important;" type="text" name="age" id="age" value=""  />
                    <label for="gender">Gender:<span class="form-required">*</span></label>
                    <input style="color: black !important;" type="text" name="gender" id="gender" value=""  />
                    <label for="work">Work:<span class="form-required">*</span></label>
                    <input style="color: black !important;" type="text" name="work" id="work" value=""  />
                    </div>

                <div data-role="fieldcontain" style="margin-top: 5%">
                    <label for="question" class="select" >Security question:</label>
                    <select name="question" id="question" data-native-menu="false">
                        <option>Choose options</option>
                        <option value="question1">Mother-in-law's maiden name?</option>
                        <option value="question2">In what city were you born?</option>
                        <option value="question3">Your dogs birth date?</option>
                        <option value="question4">Favorite food?</option>
                    </select>

                    <label for="answer">ANSWER:</label>
                    <input type="answer" name="answer" id="answer" value="" style=" margin-left: 12%;margin-top: 5%" />
                </div><!-- /fieldcontain -->  </div>
            <div style="width: 100%;margin-top: 5%;">
                <input type='submit' name="submit" value="Sign up" class='btn btn-eventPR' />
            </div>

        </form>

</div> <!--content-->
</div>         <!--wrapper-->

</body>
</html>
