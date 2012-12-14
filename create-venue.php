<?php   // Used to create venues and load them into the venue table of our database
require_once('logoutHandler.php');
require_once('checkAuth.php');

// If the user is not logged in return to index.php
if( !$loggedin ){
  header('Location: index.php');
  return;
}

// If the user pressed the submit button run this code
if ( count($_POST) > 0) {
    require_once('db.php');

    $db = db::getInstance();

    // If the user wants to upload a picture run this code
    if ($_FILES["photo"]["error"] == 0) {

        //Prepares the picture for sotring in the database
      $type = str_replace('image/', '', $_FILES['photo']['type']);

      $fileName = $_FILES['photo']['name'];
      $tmpName  = $_FILES['photo']['tmp_name'];
      $fileSize = $_FILES['photo']['size'];
      $fileType = $_FILES['photo']['type'];

      $fp      = fopen($tmpName, 'r');
      $content = fread($fp, filesize($tmpName));
      $content = addslashes($content);
      fclose($fp);

        //Query to store the picture in the database.
      $sql = "INSERT INTO Picture
              SET
                userID = '{$id}',
                ext = '{$type}',
                data = '{$content}'";

      $stmt = $db->prepare($sql);
      $stmt->execute();

        //Gets the ID of the picture
      $picID = $db->lastInsertId();
    }

    // Inserts the submitted info into the Venue table
    $sql = "INSERT INTO Venue 
        SET 
            userID = {$id},
            vName = '{$_POST['venue-name']}',
            street = '{$_POST['street']}',
            city = '{$_POST['city']}',
            state = '{$_POST['state']}',
            zipcode = '{$_POST['zipcode']}',
            GPS = '{$_POST['gps']}',
            pNumber = '{$_POST['telephone']}',
            website = '{$_POST['website']}',
            description = '{$_POST['description']}'
    ";

    // If the user uploaded a picture, save the picture ID in the profile pic attribute of the venue
    if(isset($picID)) {
      $sql .= ", profilePic= {$picID}";
    }

    // Execute the query
    $stmt = $db->prepare($sql);
    $stmt->execute();
    // get the ID of the created venue
    $venueID = $db->lastInsertId();
}

// This function redirects to the Venue profile that was just created
function redirect(){

    global $venueID;

    if(isset($_POST['submit']))
        echo "<script>".PHP_EOL."window.location='venue.php?venueID={$venueID}'".PHP_EOL."</script>";

}

?>

<!DOCTYPE html>
<html>
<head>
    <title>E-venturePR - Home</title>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

    <!-- Links to the CSS stylesheets, Bootstrap, etc. -->
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
    <!-- Links to the javasripts, JQuery, etc, scripts -->
    <script type='text/javascript' src='https://ajax.googleapis.com/ajax/libs/jquery/1.8.1/jquery.min.js'></script>
    <script type='text/javascript' src='http://cdn1.editmysite.com/editor/libraries/jquery_effects.js?1346362758'></script>
    <script type='text/javascript' src='http://cdn1.editmysite.com/editor/libraries/fancybox/fancybox.min.js?1346362758'></script>
    <script type='text/javascript' src='http://cdn1.editmysite.com/editor/images/common/utilities-jq.js?1346362758'></script>
    <script src="js/bootstrap.min.js"></script>
</head>
<body class='wsite-theme-dark no-header-page wsite-page-create-event'>
<?php
 // Before the body content is presented, run the redirect function to see if the venue was created
redirect();

?>
<div id="wrapper">
    <table id="header">
        <tr> <!-- Website logo -->
            <td id="logo"><span class='wsite-logo'><a href='index.php'><span id="wsite-title">E-venturePR</span></a></span></td>
            <td id="header-right">
                <table style="width: 150px;">

                    <!-- Checks if the user is logged to show the "Profile | Sign out" links, if not it shows "Register | Login" links -->
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

    <!-- This shows the navigation bar. -->
    <div id="navigation">
        <ul><li id='active'><a href='index.php'>Home</a></li><li id='pg145650631833651339'><a href='events.php?category=Concert'>Music</a></li><li id='pg404778243583026952'><a href='events.php?category=Sports'>Sports</a></li><li id='pg441792526610757515'><a href='events.php?category=Entertainment'>Entertainment</a></li><li id='pg269210016325162137'><a href='events.php?category=Business'>Business & Education</a></li><li id="pgabout_us"><a href="about.php">About Us</a></li></ul>
    </div>

    <!-- Here starts the container of all the main things -->
    <div id="container">
        <div id="content">
            <div class="text"><div id='wsite-content' class='wsite-not-footer'>
                <div><div class="wsite-multicol"><div class='wsite-multicol-table-wrap' style='margin:0 -15px'>
                    <table class='wsite-multicol-table'>
                        <tbody class='wsite-multicol-tbody'>
                        <tr class='wsite-multicol-tr'>
                            <td class='wsite-multicol-col' style='width:52.312775330396%;padding:0 15px'>

                                <div><div class="wsite-multicol"><div class='wsite-multicol-table-wrap' style='margin:0 -15px'>
                                    <table class='wsite-multicol-table'>
                                        <tbody class='wsite-multicol-tbody'>
                                        <tr class='wsite-multicol-tr'>

                                            <td class='wsite-multicol-col' style='width:68.805309734513%;padding:0 15px'>
                                                <!-- Back to Profile button -->
                                                <div style="text-align: left;"><a class="btn btn-eventPR" href="profile.php"><span style="font-weight: bold; font-size: 14px; font-family: Arial sans-serif;">GO BACK TO PROFILE</span></a></div>
                                                <!-- Create venue header -->
                                                <h2 style="text-align:left;">Create Venue</h2>

                                                <div>
                                                    <!-- The form for the user to fill the info for the new venue -->
                                                    <form  action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" id="create-event" enctype="multipart/form-data">
                                                        <div id="807999966852778988-form-parent" class="wsite-form-container" style="margin-top:10px;">
                                                            <ul class="formlist" id="807999966852778988-form-list">
                                                                <div><div class="wsite-form-field" style="margin:5px 0px 5px 0px;">
                                                                    <!-- Input box for the venue name -->
                                                                    <label class="wsite-form-label" for="venue-name">Venue Name: <span class="form-required">*</span></label>
                                                                    <div class="wsite-form-input-container">
                                                                        <input id="venue-name" class="wsite-form-input wsite-input" type="text" name="venue-name" style="width:200px;" />
                                                                    </div>
                                                                    <div id="instructions-461209313855761342" class="wsite-form-instructions" style="display:none;"></div>
                                                                </div></div>

                                                                <!-- Input box for the venue street -->
                                                                <div><div class="wsite-form-field" style="margin:5px 0px 5px 0px;">
                                                                    <label class="wsite-form-label" for="street">Street: <span class="form-required">*</span></label>
                                                                    <div class="wsite-form-input-container">
                                                                        <input id="street" class="wsite-form-input wsite-input" type="text" name="street" style="width:200px;" />
                                                                    </div>
                                                                    <div id="instructions-935462346745001510" class="wsite-form-instructions" style="display:none;"></div>
                                                                </div></div>

                                                                <!-- input box for the venue city -->
                                                                <div><div class="wsite-form-field" style="margin:5px 0px 5px 0px;">
                                                                    <label class="wsite-form-label" for="city">City: <span class="form-required">*</span></label>
                                                                    <div class="wsite-form-input-container">
                                                                        <input id="city" class="wsite-form-input wsite-input" type="text" name="city" style="width:200px;" />
                                                                    </div>
                                                                    <div id="instructions-935462346745001510" class="wsite-form-instructions" style="display:none;"></div>
                                                                </div></div>

                                                                <!-- input box for the state -->
                                                                <div><div class="wsite-form-field" style="margin:5px 0px 5px 0px;">
                                                                    <label class="wsite-form-label" for="state">State: <span class="form-required">*</span></label>
                                                                    <div class="wsite-form-input-container">
                                                                        <input id="state" class="wsite-form-input wsite-input" type="text" name="state" style="width:200px;" />
                                                                    </div>
                                                                    <div id="instructions-935462346745001510" class="wsite-form-instructions" style="display:none;"></div>
                                                                </div></div>

                                                                <!-- input box for the zipcode -->
                                                                <div><div class="wsite-form-field" style="margin:5px 0px 5px 0px;">
                                                                    <label class="wsite-form-label" for="zipcode">Zip code: <span class="form-required">*</span></label>
                                                                    <div class="wsite-form-input-container">
                                                                        <input id="zipcode" class="wsite-form-input wsite-input" type="text" name="zipcode" style="width:200px;" />
                                                                    </div>
                                                                    <div id="instructions-935462346745001510" class="wsite-form-instructions" style="display:none;"></div>
                                                                </div></div>

                                                                <!-- input box for the telephone -->
                                                                <div><div class="wsite-form-field" style="margin:5px 0px 5px 0px;">
                                                                    <label class="wsite-form-label" for="telephone">Telephone: <span class="form-required">*</span></label>
                                                                    <div class="wsite-form-input-container">
                                                                        <input id="telephone" class="wsite-form-input wsite-input" type="text" name="telephone" style="width:200px;" />
                                                                    </div>
                                                                    <div id="instructions-935462346745001510" class="wsite-form-instructions" style="display:none;"></div>
                                                                </div></div>

                                                                <!-- input box for the venue's location coordinates -->
                                                                <div><div class="wsite-form-field" style="margin:5px 0px 5px 0px;">
                                                                    <label class="wsite-form-label" for="gps">Coordinates: (Latitude,Longitude) <span class="form-required">*</span></label>
                                                                    <div class="wsite-form-input-container">
                                                                        <input id="gps" class="wsite-form-input wsite-input" type="text" name="gps" style="width:200px;" />
                                                                    </div>
                                                                    <div id="instructions-935462346745001510" class="wsite-form-instructions" style="display:none;"></div>
                                                                </div></div>

                                                                <!-- input box for the venue's website link-->
                                                                <div><div class="wsite-form-field" style="margin:5px 0px 5px 0px;">
                                                                    <label class="wsite-form-label" for="website">Website: <span class="form-required">*</span></label>
                                                                    <div class="wsite-form-input-container">
                                                                        <input id="website" class="wsite-form-input wsite-input" type="text" name="website" style="width:200px;" />
                                                                    </div>
                                                                    <div id="instructions-935462346745001510" class="wsite-form-instructions" style="display:none;"></div>
                                                                </div></div>

                                                                <!-- input text area for the venue's description -->
                                                                <div><div class="wsite-form-field" style="margin:5px 0px 5px 0px;">
                                                                    <label class="wsite-form-label" for="description">Description: <span class="form-required">*</span></label>
                                                                    <div class="wsite-form-input-container">
                                                                        <textarea id="description" class="wsite-form-input wsite-input" name="description" style="width:285px; height: 50px"></textarea>
                                                                    </div>
                                                                    <div id="instructions-740288841696996782" class="wsite-form-instructions" style="display:none;"></div>
                                                                </div></div>

                                                                <!-- This code is for uploading a picture -->
                                                                <div class="paragraph" style="text-align:left;">Add a Picture:</div>
                                                                <div><div class="wsite-form-field" style="margin:5px 0px 5px 0px;">

                                                                    <label class="wsite-form-label" for="photo">Upload File <span class="form-required">*</span></label>
                                                                    <div class="wsite-form-input-container">
                                                                        <input id="photo" class="wsite-form-input" type="file" name="photo" />
                                                                        <div style="font-size:10px;">Max file size: 20MB</div>
                                                                    </div>
                                                                    <div id="instructions-436611527555598588" class="wsite-form-instructions" style="display:none;"></div>
                                                                </div></div>

                                                            </ul>
                                                        </div>

                                                        <!-- button for submitting the info -->
                                                        <div style="text-align:left; margin-top:10px; margin-bottom:10px;">
                                                            <input type='submit' name='submit' value="Submit" class='btn btn-eventPR' />
                                                        </div>
                                                    </form>

                                                </div>

                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div></div></div>

                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div></div></div></div>
            </div>
        </div>
    </div>
</div>

</body>
</html>