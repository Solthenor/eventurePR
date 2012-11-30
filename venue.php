<?php
require_once('mobileRedirect.php');
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
    eventID,
    eventName,
    DATE_FORMAT(E.date, '%W, %M %e, %Y') as date
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
<span style='position:relative;float:left;z-index:10;;clear:left;margin-top:0px;*margin-top:0px'><a><img class="wsite-image galleryImageBorder" src="picture.php?picID=<?php echo $event['flyer'] ?>" style="margin-top: 5px; margin-bottom: 10px; margin-left: 0px; margin-right: 10px; border-width:1px;padding:3px;" alt="Picture" width="350" height="350"/></a><div style="display: block; font-size: 90%; margin-top: -10px; margin-bottom: 10px; text-align: center;"></div></span>
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

<div class="wsite-map"><iframe allowtransparency="true" frameborder="0" scrolling="no" style="width: 100%; height: 250px; margin-top: 10px; margin-bottom: 10px;" src="http://www.weebly.com/weebly/apps/generateMap.php?map=google&elementid=606276204773137272&ineditor=0&control=3&width=350px&height=250px&overviewmap=0&scalecontrol=0&typecontrol=0&zoom=15&long=-122.418333&lat=37.775&domain=www&point=1&align=1"></iframe></div>

<h2 style="text-align:left; font-size: 24px;">Upcoming Events at this Venue:<br /></h2>

<?php
    foreach ($events as $event) {
    ?>  
        <h2 style="text-align:left; font-size: 20px"><?php echo $event['eventName'] ?><br /></h2>
        <span class='imgPusher' style='float:left;height:0px'></span><span style='position:relative;float:left;z-index:10;;clear:left;margin-top:0px;*margin-top:0px'><a><img class="wsite-image galleryImageBorder" src="uploads/1/3/4/4/13443306/656669057.jpg?161" style="margin-top: 5px; margin-bottom: 10px; margin-left: 0px; margin-right: 10px; border-width:1px;padding:3px;" alt="Picture" /></a><div style="display: block; font-size: 90%; margin-top: -10px; margin-bottom: 10px; text-align: center;"></div></span>
        <div class="paragraph" style="text-align:left;display:block;"><?php echo $event['date'] ?><br /></div>
        <hr style="clear:both;visibility:hidden;width:100%;"></hr>
    <?php
    }
?>
</td>
</tr>
</tbody>
</table>
</div></div></div>

<div><div style="height: 20px; overflow: hidden; width: 100%;"></div>
<hr class="styled-hr" style="width:100%;"></hr>
<div style="height: 20px; overflow: hidden; width: 100%;"></div></div>

<h2 style="text-align:left;">Comments:<br /></h2>
<div class="paragraph" style="text-align:left;display:block;">No new Comments yet...<br /></div></div>
</div>
		</div>
	</div>
</div>

</body>
</html>