<?php
require_once('mobileRedirect.php');
require_once('db.php');
require_once('checkAuth.php');

$eventID = $_GET['eventID'];

if (!isset($eventID)) {
    header('Location: /index.php');
    return;
}

$db = db::getInstance();
$sql = "SELECT 
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

if(!isset($event)){
    header('Location: /index.php');
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
    else if($action == 'go'){
        $sql = "INSERT INTO Attends
                SET
                    userID = {$id}, 
                    eventID = {$eventID};";
    }

    $stmt = $db->prepare($sql);
    $stmt->execute();
}


?>
<!DOCTYPE html>
<html>
<head>
<title>Nightwish Detail - E-venturePR</title>

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
</head>
<body class='wsite-theme-dark no-header-page wsite-page-nightwish-detail'>
<div id="wrapper">
	<table id="header">
		<tr>
			<td id="logo"><span class='wsite-logo'><a href='/'><span id="wsite-title">E-venturePR</span></a></span></td>
			<td id="header-right">
				<table>
                    <?php if($loggedin) { ?>
                    <tr>
                        <td class="phone-number"><span class='wsite-text'><a href="profile.php" style="color: #32CD32; text-decoration: underline; ">Profile</a> | <a href="home.html" style="color: #32CD32; text-decoration: underline;">Log out</a></span></td>
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
        <ul><li id='active'><a href='index.php'>Home</a></li><li id='pg145650631833651339'><a href='events.php?category=Concert'>Music</a></li><li id='pg404778243583026952'><a href='/events.php?category=Sports'>Sports</a></li><li id='pg441792526610757515'><a href='/events.php?category=Entertainment'>Entertainment</a></li><li id='pg269210016325162137'><a href='/events.php?category=Business'>Business & Education</a></li><li id="pgabout_us"><a href="about.php">About Us</a></li></ul>
    </div>
	<div id="container">
		<div id="content">
			<div class="text"><div id='wsite-content' class='wsite-not-footer'>
<div><div class="wsite-multicol"><div class='wsite-multicol-table-wrap' style='margin:0 -15px'>
<table class='wsite-multicol-table'>
<tbody class='wsite-multicol-tbody'>
<tr class='wsite-multicol-tr'>
<td class='wsite-multicol-col' style='width:61.742006615215%;padding:0 15px'>

<h2 style="text-align:left;"><?php echo $event['eventName'] ?></h2>
<span class='imgPusher' style='float:left;height:0px'></span>
<span style='position:relative;float:left;z-index:10;;clear:left;margin-top:0px;*margin-top:0px'><a><img class="wsite-image galleryImageBorder" src="uploads/1/3/4/4/13443306/650380585.jpg" style="margin-top: 5px; margin-bottom: 10px; margin-left: 0px; margin-right: 10px; border-width:1px;padding:3px;" alt="Picture" /></a><div style="display: block; font-size: 90%; margin-top: -10px; margin-bottom: 10px; text-align: center;"></div></span>
<div class="paragraph" style="text-align:left;display:block;">
<?php echo $event['date'] ?>
<br />
<span style="line-height: 30px;">Time: </span>
<br />
<span style="line-height: 30px;">Location: <a href="venue.php?venueID=<?php echo $event['venueID'] ?>"><?php echo $event['venueName'] ?></a></span>
<br />
<span style="line-height: 30px;"></span>
<span style="line-height: 30px;">Genre: <?php echo $event['genre'] ?></span>
<br />
<span style="line-height: 30px;">Entrance Fee: $<?php echo $event['price'] ?><br /></span>
<br />
<?php echo $event['description'] ?>
<span style="line-height: 30px;"><br /></span><br /><span style="font-size: 12px;">posted by <a href=""><?php echo $event['userName'] ?></a></span><br /></div>
<div class="btn-toolbar" style="padding: 10px 10px 0 0; float: left;">
    <div class="btn-group">
        <div style="display: inline;"><div style="float:left; display: inline-block;"> </div>

    <form action="<?php echo $_SERVER['PHP_SELF']; ?><?php echo "?eventID={$eventID}" ?>" method="POST">
        <input name="action" type="hidden" name value="flag" />
        <input value="Flag" type="submit" class="btn btn-eventPR" style="font-weight: bold; font-size: 14px; font-family: arial sans-serif;" />Flag
    </form>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?><?php echo "?eventID={$eventID}" ?>" method="POST">
        <input name="action" type="hidden" value="go" />
        <input value="I want to go!!!" type="submit" class="btn btn-eventPR" style="font-weight: bold; font-size: 14px; font-family: arial sans-serif;" />
    </form>
    <a href="" class="btn btn-eventPR" style="font-weight: bold; font-size: 14px; font-family: arial sans-serif;">See assisting friends</a>
    </div>
    <p style="display: inline-block; font-style: italic; padding-left: 10px;"><?php echo $event['attendees'] ?> people are going</p>
</div>
<hr style="clear:both;visibility:hidden;width:100%;" />

</td>
<td class='wsite-multicol-col' style='width:38.257993384785%;padding:0 15px'>

<div class="wsite-map">
    <iframe allowtransparency="true" frameborder="0" scrolling="no" style="width: 100%; height: 250px; margin-top: 10px; margin-bottom: 10px;" src="http://www.weebly.com/weebly/apps/generateMap.php?map=google&elementid=575069644598800610&ineditor=0&control=3&width=350px&height=250px&overviewmap=0&scalecontrol=0&typecontrol=0&zoom=15&long=-122.418333&lat=37.775&domain=www&point=1&align=1"></iframe>
</div>

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
<div id='139083701912618958-imageContainer0' style='float:left;width:33.28%;margin:0;'><div id='139083701912618958-insideImageContainer0' style='position:relative;margin:5px;padding:0 8px 8px 0'><div style='position:relative;width:100%;padding:0 0 75.08%;'><a href='uploads/1/3/4/4/13443306/7495447_orig.jpg' rel='lightbox[gallery139083701912618958]' onclick='if (!window.lightboxLoaded) return false'><img src='uploads/1/3/4/4/13443306/7495447.jpg' class='galleryImage galleryImageBorder' _width='333' _height='225' style='position:absolute;border-width:1px;padding:3px;width:100%;top:5%;left:0%' /></a></div></div></div><div id='139083701912618958-imageContainer1' style='float:left;width:33.28%;margin:0;'><div id='139083701912618958-insideImageContainer1' style='position:relative;margin:5px;padding:0 8px 8px 0'><div style='position:relative;width:100%;padding:0 0 75.08%;'><a href='uploads/1/3/4/4/13443306/8485349_orig.jpg' rel='lightbox[gallery139083701912618958]' onclick='if (!window.lightboxLoaded) return false'><img src='uploads/1/3/4/4/13443306/8485349.jpg' class='galleryImage galleryImageBorder' _width='333' _height='222' style='position:absolute;border-width:1px;padding:3px;width:100%;top:5.6%;left:0%' /></a></div></div></div><div id='139083701912618958-imageContainer2' style='float:left;width:33.28%;margin:0;'><div id='139083701912618958-insideImageContainer2' style='position:relative;margin:5px;padding:0 8px 8px 0'><div style='position:relative;width:100%;padding:0 0 75.08%;'><a href='uploads/1/3/4/4/13443306/2260870_orig.jpg' rel='lightbox[gallery139083701912618958]' onclick='if (!window.lightboxLoaded) return false'><img src='uploads/1/3/4/4/13443306/2260870.jpg' class='galleryImage galleryImageBorder' _width='279' _height='250' style='position:absolute;border-width:1px;padding:3px;width:83.78%;top:0%;left:8.11%' /></a></div></div></div><div id='139083701912618958-imageContainer3' style='float:left;width:33.28%;margin:0;'><div id='139083701912618958-insideImageContainer3' style='position:relative;margin:5px;padding:0 8px 8px 0'><div style='position:relative;width:100%;padding:0 0 75.08%;'><a href='uploads/1/3/4/4/13443306/817215_orig.jpg' rel='lightbox[gallery139083701912618958]' onclick='if (!window.lightboxLoaded) return false'><img src='uploads/1/3/4/4/13443306/817215.jpg' class='galleryImage galleryImageBorder' _width='333' _height='193' style='position:absolute;border-width:1px;padding:3px;width:100%;top:11.4%;left:0%' /></a></div></div></div><span style='display: block; clear: both; height: 0px; overflow: hidden;'></span>
</div>

<div style="height: 20px; overflow: hidden;"></div></div>
</div>

</td>
<td class='wsite-multicol-col' style='width:50%;padding:0 15px'>

<h2 style="text-align:left;">Comments:<br /></h2>
    <div style="border: 1px solid #f5f5f5; padding: 20px; height: 80%; overflow: auto;
    background: -moz-linear-gradient(-45deg,  rgba(30,87,153,1) 0%, rgba(30,87,153,0.82) 24%, rgba(31,93,160,0.8) 27%, rgba(41,137,216,0.55) 50%, rgba(30,87,153,0.22) 80%, rgba(30,87,153,0) 100%);/* FF3.6+ */
background: -webkit-gradient(linear, left top, right bottom, color-stop(0%,rgba(30,87,153,1)), color-stop(24%,rgba(30,87,153,0.82)), color-stop(27%,rgba(31,93,160,0.8)), color-stop(50%,rgba(41,137,216,0.55)), color-stop(80%,rgba(30,87,153,0.22)), color-stop(100%,rgba(30,87,153,0)));  /* Chrome,Safari4+ */
background: -webkit-linear-gradient(-45deg,  rgba(30,87,153,1) 0%,rgba(30,87,153,0.82) 24%,rgba(31,93,160,0.8) 27%,rgba(41,137,216,0.55) 50%,rgba(30,87,153,0.22) 80%,rgba(30,87,153,0) 100%);   /* Chrome10+,Safari5.1+ */
background: -o-linear-gradient(-45deg,  rgba(30,87,153,1) 0%,rgba(30,87,153,0.82) 24%,rgba(31,93,160,0.8) 27%,rgba(41,137,216,0.55) 50%,rgba(30,87,153,0.22) 80%,rgba(30,87,153,0) 100%);  /* Opera 11.10+ */
background: -ms-linear-gradient(-45deg,  rgba(30,87,153,1) 0%,rgba(30,87,153,0.82) 24%,rgba(31,93,160,0.8) 27%,rgba(41,137,216,0.55) 50%,rgba(30,87,153,0.22) 80%,rgba(30,87,153,0) 100%); /* IE10+ */
background: linear-gradient(135deg,  rgba(30,87,153,1) 0%,rgba(30,87,153,0.82) 24%,rgba(31,93,160,0.8) 27%,rgba(41,137,216,0.55) 50%,rgba(30,87,153,0.22) 80%,rgba(30,87,153,0) 100%); /* W3C */
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#1e5799', endColorstr='#001e5799',GradientType=1 );/* IE6-9 fallback on horizontal gradient */ >
        <span class="imgPusher  style="float:left;height:0px;"></span><div style="opacity: 1"><span style="opacity: 1; position:relative;float:left;z-index:10;;clear:left;margin-top:0px;*margin-top:0px; opacity: 1"><a href="profile.html"><img class="wsite-image galleryImageBorder" src="uploads/1/3/4/4/13443306/397974220.jpg?74" style="margin-top: 5px; margin-bottom: 10px; margin-left: 0px; margin-right: 10px; border: 1px double gray;padding:3px; background-color: #1a1a1a;" alt="Picture"></a><div style="display: block; font-size: 90%; margin-top: -10px; margin-bottom: 10px; text-align: center;"></div></span></div>
        <div class="paragraph" style="text-align:left;display:block; color: white; font-size: medium; font-style: italic">OMG!!!! THIS IS SO COOL!!! I LOVE TARJA!! &lt;3<br></div>
        <hr style="clear:both;visibility:hidden;width:100%;">

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