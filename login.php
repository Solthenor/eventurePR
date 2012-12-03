<?php

if(isset($_COOKIE['loggedin'])){
    $loggedin = true;
    header('Location: index.php');
    return;
}

$loggedin = false;
$id = 0;

if ( count($_POST) > 0) {
    require_once('db.php');
    $db = db::getInstance();

    if($_POST['submit'] != 'Login'){

        //TODO: better validation for empty fields

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
                FROM User
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
    header('Location: index.php');
    return;
}
?>

<!DOCTYPE html>
<html>
<!-- 
Login/Registration Page

For Login: Extracts user information 
For Registration: Inserts user Information
-->
<head>
    <title>Login - E-venturePR</title>

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
<body class='wsite-theme-dark no-header-page wsite-page-login'>

<div id="wrapper">
    <table id="header">
        <tr>
            <td id="logo"><span class='wsite-logo'><a href='/index.php'><span id="wsite-title">E-venturePR</span></a></span></td>
            <td id="header-right">
                <table>
                    <?php if($loggedin) { ?>
                    <tr>
                        <td class="phone-number"><span class='wsite-text'><a href="profile.php" style="color: #32CD32; text-decoration: underline; ">Profile</a> | <a href="index.php" style="color: #32CD32; text-decoration: underline;">Log out</a></span></td>
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
        <ul><li id='active'><a href="index.php">Home</a></li><li id='pg145650631833651339'><a href='events.php?category=Concert'>Music</a></li><li id='pg404778243583026952'><a href='events.php?category=Sports'>Sports</a></li><li id='pg441792526610757515'><a href='events.php?category=Entertainment'>Entertainment</a></li><li id='pg269210016325162137'><a href='events.php?category=Business'>Business & Education</a></li><li id="pgabout_us"><a href="about.php">About Us</a></li></ul>
    </div>
    <div id="container">
        <div id="content">
            <div class="text"><div id='wsite-content' class='wsite-not-footer'>
                <div><div class="wsite-multicol"><div class='wsite-multicol-table-wrap' style='margin:0 -15px'>
                    <table class='wsite-multicol-table'>
                        <tbody class='wsite-multicol-tbody'>
                        <tr class='wsite-multicol-tr'>
                            <td class='wsite-multicol-col' style='width:50%;padding:0 15px'>

                                <div>
                                    <form  action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST" id="login">
                                        <div id="443797706409102200-form-parent" class="wsite-form-container" style="margin-top:10px;">
                                            <ul class="formlist" id="443797706409102200-form-list">
                                                <h2 style="text-align:left;">Already have an account? Login!</h2>

                                                <div><div class="wsite-form-field" style="margin:5px 0px 5px 0px;">
                                                    <label class="wsite-form-label" for="username">Username<span class="form-required">*</span></label>
                                                    <div class="wsite-form-input-container">
                                                        <input id="username" class="wsite-form-input wsite-input" type="text" name="username" style="width:370px;" />
                                                    </div>
                                                    <div id="instructions-338008156977822324" class="wsite-form-instructions" style="display:none;"></div>
                                                </div></div>

                                                <div><div class="wsite-form-field" style="margin:5px 0px 5px 0px;">
                                                    <label class="wsite-form-label" for="password">Password<span class="form-required">*</span></label>
                                                    <div class="wsite-form-input-container">
                                                        <input id="password" class="wsite-form-input wsite-input" type="password" name="password" style="width:285px;" />
                                                    </div>
                                                    <div id="instructions-190128962344944659" class="wsite-form-instructions" style="display:none;"></div>
                                                </div></div>
                                            </ul>
                                        </div>
                                        <div style="text-align:left; margin-top:10px; margin-bottom:10px;">
                                            <input type='submit' name="submit" value="Login" class='btn btn-eventPR' />
                                        </div>

                                    </form>

                                </div>

                            </td>
                            <td class='wsite-multicol-col' style='width:50%;padding:0 15px'>

                                <div>
                                    <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST" id="create-user" enctype="multipart/form-data">
                                        <div id="729044906853205765-form-parent" class="wsite-form-container" style="margin-top:10px;">
                                            <ul class="formlist" id="729044906853205765-form-list">
                                                <h2 style="text-align:left;">Register here:</h2>

                                                <div><div class="wsite-form-field" style="margin:5px 0px 5px 0px; width:380px;">
                                                    <label class="wsite-form-label" for="first-name">Name <span class="form-required">*</span></label>
                                                    <div style="clear:both;"></div>
                                                    <div class="wsite-form-input-container wsite-form-left">
                                                        <input id="first-name" class="wsite-form-input wsite-input" type="text" name="first-name" style="width:138px;" />
                                                        <label class="wsite-form-sublabel" for="first-name">First</label>
                                                    </div>
                                                    <div class="wsite-form-input-container wsite-form-right">
                                                        <input id="last-name" class="wsite-form-input wsite-input" type="text" name="last-name" style="width:205px;" />
                                                        <label class="wsite-form-sublabel" for="last-name">Last</label>
                                                    </div>
                                                    <div id="instructions-216160914622118556" class="wsite-form-instructions" style="display:none;"></div>
                                                </div>
                                                    <div style="clear:both;"></div>

                                                </div>

                                                <div><div class="wsite-form-field" style="margin:5px 0px 5px 0px;">
                                                    <label class="wsite-form-label" for="email">Email <span class="form-required">*</span></label>
                                                    <div class="wsite-form-input-container">
                                                        <input id="email" class="wsite-form-input wsite-input" type="text" name="email" style="width:370px;" />
                                                    </div>
                                                    <div id="instructions-499740599228294603" class="wsite-form-instructions" style="display:none;"></div>
                                                </div></div>

                                                <div><div class="wsite-form-field" style="margin:5px 0px 5px 0px;">
                                                    <label class="wsite-form-label" for="username">User Name <span class="form-required">*</span></label>
                                                    <div class="wsite-form-input-container">
                                                        <input id="username" class="wsite-form-input wsite-input" type="text" name="username" style="width:370px;" />
                                                    </div>
                                                    <div id="instructions-629303063250377115" class="wsite-form-instructions" style="display:none;"></div>
                                                </div></div>

                                                <div><div class="wsite-form-field" style="margin:5px 0px 5px 0px;">
                                                    <label class="wsite-form-label" for="input-703964987851636371">Password <span class="form-required">*</span></label>
                                                    <div class="wsite-form-input-container">
                                                        <input id="password" class="wsite-form-input wsite-input" type="password" name="password" style="width:370px;" />
                                                    </div>
                                                    <div id="instructions-703964987851636371" class="wsite-form-instructions" style="display:none;"></div>
                                                </div></div>

                                                <div><div class="wsite-form-field" style="margin:5px 0px 5px 0px;">
                                                    <label class="wsite-form-label" for="age">Age </label>
                                                    <div class="wsite-form-input-container">
                                                        <input id="age" class="wsite-form-input wsite-input" type="text" name="age" style="width:370px;" />
                                                    </div>
                                                    <div id="instructions-629303063250377115" class="wsite-form-instructions" style="display:none;"></div>
                                                </div></div>

                                                <div><div class="wsite-form-field" style="margin:5px 0px 5px 0px;">
                                                    <label class="wsite-form-label" for="gender">Gender </label>
                                                    <div class="wsite-form-input-container">
                                                        <select name="gender" class="form-select">
                                                            <option value='Male'>Male</option>
                                                            <option value='Female'>Female</option>
                                                        </select>
                                                    </div>
                                                    <div id="instructions-629303063250377115" class="wsite-form-instructions" style="display:none;"></div>
                                                </div></div>

                                                <div><div class="wsite-form-field" style="margin:5px 0px 5px 0px;">
                                                    <label class="wsite-form-label" for="age">Work </label>
                                                    <div class="wsite-form-input-container">
                                                        <input id="work" class="wsite-form-input wsite-input" type="text" name="work" style="width:370px;" />
                                                    </div>
                                                    <div id="instructions-629303063250377115" class="wsite-form-instructions" style="display:none;"></div>
                                                </div></div>


                                                <div><div class="wsite-form-field" style="margin:5px 0px 0px 0px;">
                                                    <label class="wsite-form-label" for="question">Security Question <span class="form-required">*</span></label>
                                                    <div class="wsite-form-radio-container">
                                                        <select name='question' class='form-select'>
                                                            <option value='0'>Favorite High-School teacher?</option>
                                                            <option value='1'>First Kiss?</option>
                                                            <option value='2'>Favorite pet's name?</option>
                                                        </select>

                                                    </div>
                                                    <div id="instructions-Security Question" class="wsite-form-instructions" style="display:none;"></div>
                                                </div></div>

                                                <div><div class="wsite-form-field" style="margin:5px 0px 5px 0px;">
                                                    <label class="wsite-form-label" for="answer">Answer: <span class="form-required">*</span></label>
                                                    <div class="wsite-form-input-container">
                                                        <input id="answer" class="wsite-form-input wsite-input" type="text" name="answer" style="width:370px;" />
                                                    </div>
                                                    <div id="instructions-629303063250377115" class="wsite-form-instructions" style="display:none;"></div>
                                                </div></div>
                                            </ul>
                                        </div>

                                        <div><div class="wsite-multicol"><div class='wsite-multicol-table-wrap' style='margin:0 -15px'>
                                            <table class='wsite-multicol-table'>
                                                <tbody class='wsite-multicol-tbody'>
                                                <tr class='wsite-multicol-tr'>


                                                    <div class="paragraph" style="text-align:left;">Add a Picture:</div>
                                                    <div><div class="wsite-form-field" style="margin:5px 0px 5px 0px;">

                                                        <label class="wsite-form-label" for="photo">Upload File </label>
                                                        <div class="wsite-form-input-container">
                                                            <input id="photo" class="wsite-form-input" type="file" name="photo" />
                                                            <div style="font-size:10px;">Max file size: 20MB</div>
                                                        </div>
                                                        <div id="instructions-436611527555598588" class="wsite-form-instructions" style="display:none;"></div>
                                                    </div></div>

                                                    <div><div class="wsite-image wsite-image-border-border-width:0 " style="padding-top:10px;padding-bottom:10px;margin-left:10px;margin-right:10px;text-align:right">

                                                        <div style="display:block;font-size:90%"></div>
                                                    </div></div>

                                                </tr>
                                                </tbody>
                                            </table>
                                        </div></div></div>

                                        <div style="text-align:left; margin-top:10px; margin-bottom:10px;">
                                            <input type='submit' name="submit" value="Sign up" class='btn btn-eventPR' />
                                        </div>

                                    </form>


                                </div>

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