<?php
require_once('logoutHandler.php');
require_once('db.php');
require_once('checkAuth.php');

$venueID = $_GET['venueID'];

if (!isset($venueID)) {
    header('Location: index.php');
    return;
}

$db = db::getInstance();
$sql = "SELECT 
            V.vName, 
            V.website, 
            V.GPS, 
            V.pNumber, 
            V.street,
            V.city, 
            V.state, 
            V.zipcode, 
            V.profilePic, 
            V.description
        FROM Venue V
        WHERE V.venueID = {$venueID};
";

$eventsSql = "SELECT
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
            E.userID
FROM Event E
    INNER JOIN Venue V
        ON E.venueID = V.venueID
WHERE E.venueID = {$venueID}
LIMIT 2
";


$stmt = $db->prepare($sql);
$stmt->execute();

$eStmt = $db->prepare($eventsSql);
$eStmt->execute();

$result = $stmt->fetchAll();
$events = $eStmt->fetchAll();

$venue = $result[0];

if(!isset($venue)){
    header('Location: index.php');
    return;
}

?>
<!DOCTYPE html>
<html>
<head>
<title>Venue - E-venturePR</title>

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
    <script type='text/javascript' src='https://ajax.googleapis.com/ajax/libs/jquery/1.8.1/jquery.min.js'></script>
    <script type='text/javascript' src='http://cdn1.editmysite.com/editor/libraries/jquery_effects.js?1346362758'></script>
    <script type='text/javascript' src='http://cdn1.editmysite.com/editor/libraries/fancybox/fancybox.min.js?1346362758'></script>
    <script type='text/javascript' src='http://cdn1.editmysite.com/editor/images/common/utilities-jq.js?1346362758'></script>
    <script type='text/javascript' src='http://cdn1.editmysite.com/editor/libraries/flyout_menus_jq.js?1346362758'></script>

    <script type="text/javascript" language="JavaScript" src="http://j.maxmind.com/app/geoip.js"></script>
    <script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?sensor=false"></script>
    <script type="text/javascript">
        var directionsDisplay;
        var directionsService = new google.maps.DirectionsService();
        var map;
        function initialize() {
            directionsDisplay = new google.maps.DirectionsRenderer();

            var options =
            {
                zoom: 10,
                center: new google.maps.LatLng(geoip_latitude(), geoip_longitude()),
                mapTypeId: google.maps.MapTypeId.ROADMAP,
                mapTypeControl: true,
                mapTypeControlOptions:
                {
                    style: google.maps.MapTypeControlStyle.DROPDOWN_MENU,
                    position: google.maps.ControlPosition.TOP_RIGHT,
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
            directionsDisplay.setMap(map);
            // Add Marker and Listener
            var latlng = new google.maps.LatLng(geoip_latitude(), geoip_longitude());
            calcRoute();

        }

        function calcRoute() {
            var start = new google.maps.LatLng(geoip_latitude(), geoip_longitude());
            var end = new google.maps.LatLng(<?php echo $venue['GPS'] ?>);
            var request = {
                origin:start,
                destination:end,
                travelMode: google.maps.TravelMode.DRIVING
            };
            directionsService.route(request, function(result, status) {
                if (status == google.maps.DirectionsStatus.OK) {
                    directionsDisplay.setDirections(result);
                }
            });
        }
        window.onload = initialize;
    </script>

</head>
<body class='wsite-theme-dark no-header-page wsite-page-venue'>
<div id="wrapper">
    <table id="header">
        <tr>
            <td id="logo"><span class='wsite-logo'><a href='/'><span id="wsite-title">E-venturePR</span></a></span></td>
            <td id="header-right">
                <table style="width:150px;">
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
<h2 style="text-align:left;"><font size="6">Venue Profile</font><br /></h2>

<div><div class="wsite-multicol"><div class='wsite-multicol-table-wrap' style='margin:0 -15px'>
<table class='wsite-multicol-table'>
<tbody class='wsite-multicol-tbody'>
<tr class='wsite-multicol-tr'>
<td class='wsite-multicol-col' style='width:58.700440528634%;padding:0 15px'>

<h2 style="text-align:left;"><?php echo $venue['vName'] ?><br /></h2>
<span class='imgPusher' style='float:left;height:0px'></span>
<span style='position:relative;float:left;z-index:10;;clear:left;margin-top:0px;*margin-top:0px'>
<span class='imgPusher' style='float:left;height:0px'></span><span style='position:relative;float:left;z-index:10;;clear:left;margin-top:0px;*margin-top:0px'><a><img class="wsite-image galleryImageBorder" src="picture.php?picID=<?php echo $venue['profilePic'] ?>" style="margin-top: 5px; margin-bottom: 10px; margin-left: 0px; margin-right: 10px; border-width:1px;padding:3px;width:200px;" alt="Picture" /></a><div style="display: block; font-size: 90%; margin-top: -10px; margin-bottom: 10px; text-align: center;"></div></span>
    <div style="display: block; font-size: 90%; margin-top: -10px; margin-bottom: 10px; text-align: center;"></div>
</span>
<div class="paragraph" style="text-align:left;display:block;">               
    <font size="3"><strong>Location:</strong></font>
    <br />                 
    <?php echo $venue['street'] ?> <?php echo $venue['city'] ?> <?php echo $venue['state'] ?> <?php echo $venue['zipcode'] ?>
    <br /><br />               
    Tel- <?php echo $venue['pNumber'] ?><br />                 
    <span>Website: </span>
    <a href="<?php echo $venue['website'] ?>">
        <strong><?php echo $venue['website'] ?></strong>
    </a><br /><br />
    <span><strong>I<font size="3">nfo:</font></strong> </span>
    <?php echo $venue['description'] ?>
    </div>
<hr style="clear:both;visibility:hidden;width:100%;"></hr>

<div style="text-align:left;"><div style="height: 10px; overflow: hidden;"></div>
<a class="wsite-button wsite-button-small wsite-button-highlight btn-eventurePR" href="create-event.php" >
<span class="wsite-button-inner">Create an event for this venue</span>
</a>
<div style="height: 10px; overflow: hidden;"></div></div>

</td>
<td class='wsite-multicol-col' style='width:41.299559471366%;padding:0 15px'>

    <div class="wsite-map" style="padding-top: 100px;" >
        <div id="map" style="height: 200px; width: 300px" />

    </div>

<h2 style="text-align:left; font-size: 24px;">Upcoming Events at this Venue:<br /></h2>

<?php
    foreach ($events as $event) {
    ?>  
        <a href="event.php?eventID=<?php echo $event['eventID'] ?>"><h2 style="text-align:left; font-size: 20px"><?php echo $event['eventName'] ?><br /></h2></a>
        <span class='imgPusher' style='float:left;height:0px'></span><span style='position:relative;float:left;z-index:10;;clear:left;margin-top:0px;*margin-top:0px'><a href="event.php?eventID=<?php echo $event['eventID'] ?>"><img class="wsite-image galleryImageBorder" src="picture.php?picID=<?php echo $event['flyer'] ?>" style="margin-top: 5px; margin-bottom: 10px; margin-left: 0px; margin-right: 10px; border-width:1px;padding:3px;" alt="Picture" width="200" height="300"/><div style="display: block; font-size: 90%; margin-top: -10px; margin-bottom: 10px; text-align: center;"></div></span></a>
        <div class="paragraph" style="text-align:left;display:block;"><?php echo $event['date'] ?><br /></div>
        <hr style="clear:both;visibility:hidden;width:100%;" />
    <?php
    }
?>
</td>
</tr>
</tbody>
</table>
</div></div></div>

</div>
</div>
		</div>
	</div>
</div>

</body>
</html>