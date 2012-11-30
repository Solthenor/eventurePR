<?php                   // Displays the event information on the web page. This view is set from the information of an event created.
require_once('mobileRedirect.php');
require_once('logoutHandler.php');
require_once('db.php');
require_once('checkAuth.php');

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
            E.userID,
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
$eventUserID = $event['userID'];
$attendees = $event['attendees'];

if (isset($_POST['upload'])) {
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

      $sql = "INSERT INTO Gallery
            SET
              userID = '{$eventUserID}',
              eventID = '{$eventID}',
              ext = '{$type}',
              data = '{$content}'";

      $stmt = $db->prepare($sql);
      $stmt->execute();

      // $picID = $db->lastInsertId();
    }
}

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

if(isset($_POST['submit'])) {
    
    

    $db = db::getInstance();

    $sql = "INSERT INTO Comment
            SET
               userID = {$id},
               eventID= {$eventID},
               content = '{$_POST['comment-text']}';";

    $stmt = $db->prepare($sql);
    $stmt->execute();

}


?>
<!DOCTYPE html>
<html>
<head>
<title><?php echo $event['eventName'] ?> - E-venturePR</title>

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
<script type='text/javascript' src='http://cdn1.editmysite.com/editor/libraries/jquery_effects.js?1346362758'></script>
<script type='text/javascript' src='http://cdn1.editmysite.com/editor/libraries/fancybox/fancybox.min.js?1346362758'></script>
<script type='text/javascript' src='http://cdn1.editmysite.com/editor/images/common/utilities-jq.js?1346362758'></script>
<script type='text/javascript' src='http://cdn1.editmysite.com/editor/libraries/flyout_menus_jq.js?1346362758'></script>

    <script type="text/javascript" language="JavaScript" src="http://j.maxmind.com/app/geoip.js"></script>
    <script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?sensor=false"></script>
</head>
<body class='wsite-theme-dark no-header-page wsite-page-nightwish-detail'>

<script type="text/javascript">
    var map;
    function initialize() {
        var options =
        {
            zoom: 10,
            center: new google.maps.LatLng(geoip_latitude(), geoip_longitude()),
            mapTypeId: google.maps.MapTypeId.ROADMAP,
            mapTypeControl: true,
            mapTypeControlOptions:
            {
                style: google.maps.MapTypeControlStyle.DROPDOWN_MENU,
                poistion: google.maps.ControlPosition.TOP_RIGHT,
                mapTypeIds: [google.maps.MapTypeId.ROADMAP,
                    google.maps.MapTypeId.TERRAIN,
                    google.maps.MapTypeId.HYBRID,
                    google.maps.MapTypeId.SATELLITE]
            },
            navigationControl: true,
            navigationControlOptions:
            {
                style: google.maps.NavigationControlStyle.ZOOM_PAN
            },
            scaleControl: true,
            disableDoubleClickZoom: true,
            draggable: false,
            streetViewControl: true,
            draggableCursor: 'move'
        };
        map = new google.maps.Map(document.getElementById("map"), options);
        // Add Marker and Listener
        var latlng = new google.maps.LatLng(geoip_latitude(), geoip_longitude());
        var marker = new google.maps.Marker
            (
                {
                    position: latlng,
                    map: map,
                    title: 'Click me'
                }
            );
        var infowindow = new google.maps.InfoWindow({
            content: 'You Are Here'
        });
        google.maps.event.addListener(marker, 'click', function () {
            // Calling the open method of the infoWindow
            infowindow.open(map, marker);
        });
    }
    window.onload = initialize;
</script>
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
<div><div class="wsite-multicol"><div class='wsite-multicol-table-wrap' style='margin:0 -15px'>
<table class='wsite-multicol-table'>
<tbody class='wsite-multicol-tbody'>
<tr class='wsite-multicol-tr'>
<td class='wsite-multicol-col' style='width:61.742006615215%;'>

<h2 style="text-align:left;"><?php echo $event['eventName'] ?></h2>
<span class='imgPusher' style='float:left;height:0px'></span>
<span style='position:relative;float:left;z-index:10;;clear:left;margin-top:0px;*margin-top:0px'><a><img class="wsite-image galleryImageBorder" src="picture.php?picID=<?php echo $event['flyer'] ?>" style="margin-top: 5px; margin-bottom: 10px; margin-left: 0px; margin-right: 10px; border-width:1px;padding:3px;" alt="Picture" width="350" height="350"/></a><div style="display: block; font-size: 90%; margin-top: -10px; margin-bottom: 10px; text-align: center;"></div></span>
<div class="paragraph" style="text-align:left;display:block;">
<?php echo $event['date'] ?>
<br />
<span style="line-height: 30px;">Start Time:  <?php echo $event['startHour'] ?></span>
<br />
<span style="line-height: 30px;">End Time:  <?php echo $event['endHour'] ?></span>
<br />
<span style="line-height: 30px;">Location:  <a href="venue.php?venueID=<?php echo $event['venueID'] ?>"><?php echo $event['venueName'] ?></a></span>
<br />
<span style="line-height: 30px;">Type:  <?php echo $event['eventType'] ?></span>
<br />
<span style="line-height: 30px;">Genre:  <?php echo $event['genre'] ?></span>
<br />
<span style="line-height: 30px;">Entrance Fee:  $<?php echo $event['price'] ?><br /></span>
<br />
<?php echo $event['description'] ?>
<span style="line-height: 30px;"><br /></span><br /><span style="font-size: 12px;">posted by <a href="profile.php?userID=<?php echo $event['userID'] ?>"><?php echo $event['userName'] ?></a></span><br /></div>
<div class="btn-toolbar" style="padding: 10px 10px 0 0; float: left;">
    <div class="btn-group">
        <div style="display: inline;"><div style="float:left; display: inline-block;"> </div>


    <form action="<?php echo $_SERVER['PHP_SELF']; ?><?php echo "?eventID={$eventID}" ?>" method="POST">
        
        <input name="action" value="Count me in" type="submit" class="btn btn-eventPR" style="font-weight: bold; font-size: 14px; font-family: arial sans-serif;"  />
    </form>
    
    
    <!--
    <a href="contacts.php" class="btn btn-eventPR" style="font-weight: bold; font-size: 14px; font-family: arial sans-serif;">See assisting friends</a>
    -->

        <div id="example" class="modal hide fade in" style="display: none; ">  
        <div class="modal-header">  
        <a class="close" data-dismiss="modal">×</a>  
        <h3>This is a Modal Heading</h3>  
        </div>  
        <div class="modal-body">  
        <h4>Text in a modal</h4>  
        <p>You can add some text here.</p>                
        </div>  
        <div class="modal-footer">  
        <a href="#" class="btn btn-success">Call to action</a>  
        <a href="#" class="btn" data-dismiss="modal">Close</a>  
        </div>  
        </div>  
        <a data-toggle="modal" href="#example" class="btn btn-eventPR">Who's going</a>
        
    <p style="display: inline-block; font-style: italic; padding-left: 10px;"><?php echo $attendees ?> people are going</p>

    <form action="<?php echo $_SERVER['PHP_SELF']; ?><?php echo "?eventID={$eventID}" ?>" method="POST">
        <input name="action" value="Flag" type="submit" class="btn btn-eventPR" style="font-weight: bold; font-size: 14px; font-family: arial sans-serif;" />
    </form>
</div>
<hr style="clear:both;visibility:hidden;width:100%;" />

</td>
<td class='wsite-multicol-col' style='width:38.257993384785%;padding:0 15px'>

<div class="wsite-map" style="padding-top: 100px;" >
    <div id="map" style="height: 200px; width: 300px" />

</div>

    <div style="text-align:left;"><div style="height: 10px; overflow: hidden;"></div>
        <a class="wsite-button wsite-button-small wsite-button-highlight" href="javascript:;" >
            <span class="wsite-button-inner">Find tickets</span>
        </a>
        <div style="height: 10px; overflow: hidden;"></div></div>

    <div style="text-align:left;"><div style="height: 10px; overflow: hidden;"></div>
        <a class="wsite-button wsite-button-small wsite-button-highlight" href="share.php?eventID=<?php echo $event['eventID'] ?>">
            <span class="wsite-button-inner" name="share">Share E-venture</span>
        </a>
        <div style="height: 10px; overflow: hidden;"></div></div>

    <div style="text-align:left;"><div style="height: 10px; overflow: hidden;"></div>
        <a class="wsite-button wsite-button-small wsite-button-highlight" href="javascript:;" >
            <span class="wsite-button-inner">set calendar</span>
        </a>
        <div style="height: 10px; overflow: hidden;"></div></div>

</td>
</tr>
</tbody>
</table>
</div></div></div>

<div><div class="wsite-multicol"><div class='wsite-multicol-table-wrap' style='margin:0 -15px'>
<table class='wsite-multicol-table'>
<tbody class='wsite-multicol-tbody'>
<tr class='wsite-multicol-tr'>
<td class='wsite-multicol-col' style='width:50%;padding:0 15px'>
    <h2 style="text-align:left;">Upload pics of your E-venture!!!</h2>
<div>
<div><div style="height: 20px; overflow: hidden;"></div>
<div id='139083701912618958-gallery' class='imageGallery' style='line-height: 0px; padding: 0; margin: 0'>

<?php

/*    $db = db::getInstance();
    $sql = "SELECT
                G.userID,
                G.picID,
                G.eventID,
                G.ext,
                G.data
            FROM Gallery G
            WHERE G.eventID = $eventID;
    ";

    $stmt = $db->prepare($sql);
    $stmt->execute();

    $result = $stmt->fetchAll();

    foreach ($result as &$pic) { ?>
    <div id='139083701912618958-imageContainer0' style='float:left;width:33.28%;margin:0;'><div id='139083701912618958-insideImageContainer0' style='position:relative;margin:5px;padding:0 8px 8px 0'><div style='position:relative;width:100%;padding:0 0 75.08%;'><a><img src='picture.php?picID=<?php echo $pic['picID']; ?>" class='galleryImage galleryImageBorder' _width='333' _height='225' style='position:absolute;border-width:1px;padding:3px;width:100%;top:5%;left:0%' /></a></div></div></div>;  <!-- <div id='139083701912618958-imageContainer1' style='float:left;width:33.28%;margin:0;'><div id='139083701912618958-insideImageContainer1' style='position:relative;margin:5px;padding:0 8px 8px 0'><div style='position:relative;width:100%;padding:0 0 75.08%;'><a href='uploads/1/3/4/4/13443306/8485349_orig.jpg' rel='lightbox[gallery139083701912618958]' onclick='if (!window.lightboxLoaded) return false'><img src='uploads/1/3/4/4/13443306/8485349.jpg' class='galleryImage galleryImageBorder' _width='333' _height='222' style='position:absolute;border-width:1px;padding:3px;width:100%;top:5.6%;left:0%' /></a></div></div></div><div id='139083701912618958-imageContainer2' style='float:left;width:33.28%;margin:0;'><div id='139083701912618958-insideImageContainer2' style='position:relative;margin:5px;padding:0 8px 8px 0'><div style='position:relative;width:100%;padding:0 0 75.08%;'><a href='uploads/1/3/4/4/13443306/2260870_orig.jpg' rel='lightbox[gallery139083701912618958]' onclick='if (!window.lightboxLoaded) return false'><img src='uploads/1/3/4/4/13443306/2260870.jpg' class='galleryImage galleryImageBorder' _width='279' _height='250' style='position:absolute;border-width:1px;padding:3px;width:83.78%;top:0%;left:8.11%' /></a></div></div></div><div id='139083701912618958-imageContainer3' style='float:left;width:33.28%;margin:0;'><div id='139083701912618958-insideImageContainer3' style='position:relative;margin:5px;padding:0 8px 8px 0'><div style='position:relative;width:100%;padding:0 0 75.08%;'><a href='uploads/1/3/4/4/13443306/817215_orig.jpg' rel='lightbox[gallery139083701912618958]' onclick='if (!window.lightboxLoaded) return false'><img src='uploads/1/3/4/4/13443306/817215.jpg' class='galleryImage galleryImageBorder' _width='333' _height='193' style='position:absolute;border-width:1px;padding:3px;width:100%;top:11.4%;left:0%' /></a></div></div></div><span style='display: block; clear: both; height: 0px; overflow: hidden;'></span>  -->
    <php } */ ?>


</div>

<div style="height: 20px; overflow: hidden;"></div></div>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
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
        </form>

</div>

    <div style="text-align:left; margin-top:10px; margin-bottom:10px;">
        <input type="submit" name="upload" value="Upload" class='btn btn-eventPR' />
    </div>
</td>
    <td class='wsite-multicol-col' style='width:50%;padding:0 15px'>

        <h2 style="text-align:left;">Wall:<br /></h2>
        <div style="border: 1px solid #f5f5f5; padding: 20px; height: 60%; overflow: auto; background-color:black;">
            
            <!--

                                    <span class="imgPusher" style="float:left;height:0px"></span>
                                    <div style="position:relative;float:left;z-index:10;width:70px;clear:left;margin-top:0px;*margin-top:0px">
                                    <a><img class="wsite-image galleryImageBorder" src="picture.php?picID={$comment['profilePicture'] }" style="margin-top: 5px; margin-bottom: 10px; margin-left: 0px; margin-right: 10px; border: 1px double gray;padding:3px; background-color: #1a1a1a;" alt="Picture">
                                    </a>
                                    <div style="display: block; font-size: 90%; margin-top: -10px; margin-bottom: 10px; text-align: center;"></div></div>
                                    -->
            

            <hr style="clear:both;visibility:hidden;width:100%;">

        </div>
        <form action="event.php" method="POST" id="submit" enctype="multipart/form-data">
                        <div><div class="wsite-form-field" style="margin:5px 0px 5px 0px;">
                            <label class="wsite-form-label" for="description">Post to wall: <span class="form-required">*</span></label>
                            <div class="wsite-form-input-container">
                                <textarea id="description" class="wsite-form-input wsite-input" name="comment-text" style="width:285px; height: 50px"></textarea>
                            </div>
                            <div id="instructions-740288841696996782" class="wsite-form-instructions" style="display:none;"></div>
                        </div></div>
                        <div style="text-align:left; margin-top:10px; margin-bottom:10px;">
                            <input type='submit' name="submit" value="Post" class='btn btn-eventPR' />
                        </div>
                    </form>


</div></div>
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


<script src="http://code.jquery.com/jquery-latest.js"></script>
    <script src="js/bootstrap.min.js"></script>
</body>
</html>