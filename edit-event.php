<?php         // Creates events and loads them into the Event table in our Database
require_once('logoutHandler.php');
require_once('db.php');
require_once('checkAuth.php');

if( !$loggedin ){
  header('Location: index.php');
  return;
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
            DATE_FORMAT(E.date, '%Y-%m-%d') as date, 
            E.startHour,
            E.endHour,
            E.status,
            E.featured, 
            E.price, 
            E.flag,
            E.description,
            V.venueID,
            V.vName as venueName,
            V.GPS,
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

if ($eventUserID != $id) {
    header('Location: index.php');
    return;
}

$picID = 0;

if ( count($_POST) > 0) {
  $startHour = $_POST['start-hour'] . ":00";
  $endHour = $_POST['end-hour'] . ":00";
  $name = addslashes($_POST['event-name']);
  $description = addslashes($_POST['description']);
  if(empty($_POST['date'])){
    $sql = "UPDATE Event
            SET
              eventName = '{$name}',
              venueID = '{$_POST['venue']}',
              eventType = '{$_POST['type']}',
              genre = '{$_POST['genre']}',
              startHour = '{$startHour}',
              endHour = '{$endHour}',
              featured = '{$_POST['featured']}',
              price = '{$_POST['price']}',
              description = '{$description}'
            WHERE eventID = {$eventID}
    ";
  }
  else {
    $date = $_POST['date'];
    $sql = "UPDATE Event
            SET
              eventName = '{$name}',
              venueID = '{$_POST['venue']}',
              eventType = '{$_POST['type']}',
              genre = '{$_POST['genre']}',
              date = '{$date}',
              startHour = '{$startHour}',
              endHour = '{$endHour}',
              featured = '{$_POST['featured']}',
              price = '{$_POST['price']}',
              description = '{$description}'
            WHERE eventID = {$eventID}
    ";
  }

  $stmt = $db->prepare($sql);
  $stmt->execute();

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

    $sql = "UPDATE Event
            SET
              flyer = {$picID}
            WHERE eventID = {$eventID}
    ";

    $stmt = $db->prepare($sql);
    $stmt->execute();
  }

  header("Location: event.php?eventID={$eventID}");
  return;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit - E-venturePR</title>

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
    <link rel="stylesheet" href="http://code.jquery.com/ui/1.9.1/themes/base/jquery-ui.css" />
    <script src="http://code.jquery.com/jquery-1.8.2.js"></script>
    <script src="http://code.jquery.com/ui/1.9.1/jquery-ui.js"></script>
    <link rel="stylesheet" href="/resources/demos/style.css" />
    <script>
        $(function() {
            $( "#datepicker" ).datepicker({ minDate: 0, maxDate: "+2Y" });
            $( "#datepicker" ).datepicker( "option", "dateFormat", "yy-mm-dd" );
        });
    </script>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <script type="text/javascript">

        var type = [];
        type["blank"] = [""];
        type["Concert"] = ["Alternative", "Rock","Pop", "Hip Hop / Rap","Electronic", "Country", "Classical"];
        type["Sports"] = ["Basketball","Baseball","Soccer","Volleyball","Tennis","Boxing","Swimming","Cycling"];
        type["Entertainment"] = ["Culinary","Cinema","Arts","Theater","Comedy","Politics"];
        type["Business"] = ["Conferences","Meetings","Seminars","JobFairs","Sales"];

        function fillSelect(nValue,nList){

            nList.options.length = 1;
            var curr = type[nValue];
            for (each in curr)
            {
                var nOption = document.createElement('option');
                nOption.appendChild(document.createTextNode(curr[each]));
                nOption.setAttribute("value",curr[each]);
                nList.appendChild(nOption);
            }
        }

    </script>

</head>
<body class='wsite-theme-dark no-header-page wsite-page-create-event'>
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
<td class='wsite-multicol-col' style='width:52.312775330396%;padding:0 15px'>

<div><div class="wsite-multicol"><div class='wsite-multicol-table-wrap' style='margin:0 -15px'>
<table class='wsite-multicol-table'>
<tbody class='wsite-multicol-tbody'>
<tr class='wsite-multicol-tr'>

<td class='wsite-multicol-col' style='width:68.805309734513%;padding:0 15px'>
<h2 style="text-align:left;">Edit E-Vent</h2>

<div>
<form action="<?php echo $_SERVER['PHP_SELF'] . "?eventID={$eventID}" ?>" method="POST" id="edit-event" enctype="multipart/form-data">
<div id="807999966852778988-form-parent" class="wsite-form-container" style="margin-top:10px;">
  <ul class="formlist" id="807999966852778988-form-list">
    <div><div class="wsite-form-field" style="margin:5px 0px 5px 0px;">
  <label class="wsite-form-label" for="event-name">Event Name <span class="form-required">*</span></label>
  <div class="wsite-form-input-container">
    <input id="event-name" class="wsite-form-input wsite-input" type="text" name="event-name" value="<?php echo $event['eventName'] ?>" style="width:200px;" />
  </div>
  <div id="instructions-461209313855761342" class="wsite-form-instructions" style="display:none;"></div>
</div></div>

<!--
<div><div class="wsite-form-field" style="margin:5px 0px 5px 0px;">
  <label class="wsite-form-label" for="date">Date <span class="form-required">*</span></label>
  <div class="wsite-form-input-container">
    <input id="date" class="wsite-form-input wsite-input" type="text" name="date" style="width:200px;" />
  </div>
  <div id="instructions-376105289394483033" class="wsite-form-instructions" style="display:none;"></div>
</div></div> -->

<div><div class="wsite-form-field" style="margin:5px 0px 0px 0px;">
    <label class="wsite-form-label" for="venue">Select a Venue: <span class="form-required">*</span></label>
    <div class="wsite-form-radio-container">
        <select name='venue' class='form-select'>
          <?php
            $db = db::getInstance();
            $sql = "SELECT venueID V, vName N FROM Venue";
            $stmt = $db->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetchAll();
            foreach ($result as &$venue) {
              echo "<option value='{$venue['V']}'>{$venue['N']}</option>";
            }
          ?>
        </select>

    </div>
    <div id="instructions-Select a Genre:" class="wsite-form-instructions" style="display:none;"></div>
</div></div>

      <div><div class="wsite-form-field" style="margin:5px 0px 0px 0px;">
          <label class="wsite-form-label" for="type">Select a Type: <span class="form-required">*</span></label>
          <div class="wsite-form-radio-container">
              <select name='type' class="form-select"  onchange="fillSelect(this.value,this.form['genre'])">
                  <option value='blank'>Select a Type</option>
                  <option value='Concert'>Concert</option>
                  <option value='Sports'>Sports</option>
                  <option value='Entertainment'>Entertainment</option>
                  <option value='Business'>Business &amp; Education</option>
              </select>

          </div>
          <div id="instructions-Select a Genre:" class="wsite-form-instructions" style="display:none;"></div>
      </div></div>

<div><div class="wsite-form-field" style="margin:5px 0px 0px 0px;">
  <label class="wsite-form-label" for="genre">Select a Genre: <span class="form-required">*</span></label>
  <div class="wsite-form-radio-container">

    <select name='genre' class='form-select'>

        <option value="">Select a Genre</option>
</select>

  </div>
  <div id="instructions-Select a Genre:" class="wsite-form-instructions" style="display:none;"></div>
</div></div>

      <div><div class="wsite-form-field" style="margin:5px 0px 5px 0px;">
          <label class="wsite-form-label" for="date">Date: (year-month-day)<span class="form-required">*</span></label>
          <div class="wsite-form-input-container">
              <input type="text" id="datepicker" name="date" value="<?php echo $event['date'] ?>" />

          </div>
          <div id="instructions-461209313855761342" class="wsite-form-instructions" style="display:none;"></div>
      </div></div>

      <div><div class="wsite-form-field" style="margin:5px 0px 5px 0px;">
          <label class="wsite-form-label" for="start-hour">Start Hour: (hour:minutes)<span class="form-required">*</span></label>
          <div class="wsite-form-input-container">
              <input id="event-name" class="wsite-form-input wsite-input" type="text" name="start-hour" value="<?php echo $event['startHour'] ?>" style="width:200px;" />
          </div>
          <div id="instructions-461209313855761342" class="wsite-form-instructions" style="display:none;"></div>
      </div></div>

      <div><div class="wsite-form-field" style="margin:5px 0px 5px 0px;">
          <label class="wsite-form-label" for="end-hour">End Hour: (hour:minutes) <span class="form-required">*</span></label>
          <div class="wsite-form-input-container">
              <input id="event-name" class="wsite-form-input wsite-input" type="text" name="end-hour" value="<?php echo $event['endHour'] ?>" style="width:200px;" />
          </div>
          <div id="instructions-461209313855761342" class="wsite-form-instructions" style="display:none;"></div>
      </div></div>

    <div><div class="wsite-form-field" style="margin:5px 0px 0px 0px;">
          <label class="wsite-form-label" for="private">Public or Private? <span class="form-required">*</span></label>
          <div class="wsite-form-radio-container">
              <select name='private' class='form-select'>
                  <option value='0'>Public</option>
                  <option value='1'>Private</option>
              </select>

          </div>
          <div id="instructions-Select a Genre:" class="wsite-form-instructions" style="display:none;"></div>
      </div></div>

      <div><div class="wsite-form-field" style="margin:5px 0px 5px 0px;">
          <label class="wsite-form-label" for="featured">Featured? <span class="form-required">*</span></label>
          <div class="wsite-form-radio-container">
              <select name='featured' class='form-select'>
                  <option value='0'>No</option>
                  <option value='1'>Yes</option>
              </select>
          <div id="instructions-461209313855761342" class="wsite-form-instructions" style="display:none;"></div>
      </div></div>

          <div><div class="wsite-form-field" style="margin:5px 0px 5px 0px;">
              <label class="wsite-form-label" for="price">Entrance Fee: <span class="form-required">*</span></label>
              <div class="wsite-form-input-container">
                  <input id="event-name" class="wsite-form-input wsite-input" type="text" name="price" value="<?php echo $event['price'] ?>" style="width:200px;" />
              </div>
              <div id="instructions-461209313855761342" class="wsite-form-instructions" style="display:none;"></div>
          </div></div>

<div><div class="wsite-form-field" style="margin:5px 0px 5px 0px;">
  <label class="wsite-form-label" for="description">Brief Description <span class="form-required">*</span></label>
  <div class="wsite-form-input-container">
    <textarea id="description" class="wsite-form-input wsite-input" name="description" style="width:285px; height: 50px"><?php echo $event['description'] ?></textarea>
  </div>
  <div id="instructions-740288841696996782" class="wsite-form-instructions" style="display:none;"></div>
</div></div>
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
<div style="text-align:left; margin-top:10px; margin-bottom:10px;">
  <input type='submit' name="submit" value="Submit" class='btn btn-eventPR' />
</div>

</form>

</div>

</td>
</tr>
</tbody>
</table>
</div></div></div>

</td>

<td class='wsite-multicol-col' style='width:47.687224669604%;padding:0 15px'>

<div><div class="wsite-multicol"><div class='wsite-multicol-table-wrap' style='margin:0 -15px'>
<table class='wsite-multicol-table'>
<tbody class='wsite-multicol-tbody'>
<tr class='wsite-multicol-tr'>


<div class="paragraph" style="text-align:left;">Add a Picture:</div>
<div><div class="wsite-form-field" style="margin:5px 0px 5px 0px;">


<div><div class="wsite-image wsite-image-border-border-width:0 " style="padding-top:10px;padding-bottom:10px;margin-left:10px;margin-right:10px;text-align:right">

<div style="display:block;font-size:90%"></div>
</div></div>

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