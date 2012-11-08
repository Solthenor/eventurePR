<?php
require_once('mobileRedirect.php');
require_once('db.php');
require_once('checkAuth.php');

if( !$loggedin ){
  header('Location: index.php');
}

$picID = 0;

if ( count($_POST) > 0) {

  $db = db::getInstance();

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
  }


    //TODO: better validation for empty fields

  // startHour = '{$_POST['startHour']}',
              //date = '{$_POST['date']}',
             // endHour = '{$_POST['endHour']}',
              //featured = '{$_POST['featured']}',
              //price = '{$_POST['price']}',     
    $sql = "INSERT INTO Event
            SET
              userID = '{$id}',
              eventName = '{$_POST['event-name']}',
              
              venueID = '{$_POST['venue']}',
              eventType = '{$_POST['type']}',
              genre = '{$_POST['genre']}',
              status = '{$_POST['private']}',  
                  
              description = '{$_POST['description']}'
    ";

    if(isset($picID)) {
      $sql .= ", flyer= {$picID}";
    }

    $stmt = $db->prepare($sql);
    $stmt->execute();


}
?>

<!DOCTYPE html>
<html>
<head>
    <title>E-venturePR - Home</title>

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
<body class='wsite-theme-dark no-header-page wsite-page-create-event'>
<div id="wrapper">
	<table id="header">
		<tr>
			<td id="logo"><span class='wsite-logo'><a href='/'><span id="wsite-title">E-venturePR</span></a></span></td>
			<td id="header-right">
				<table>
          <?php if($loggedin) { ?>
          <tr>
              <td class="phone-number"><span class='wsite-text'><a href="profile.php" style="color: #32CD32; text-decoration: underline; "><?php echo $user['userName'] ?></a> | <a href="index.php" style="color: #32CD32; text-decoration: underline;">Log out</a></span></td>
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
    <div style="text-align: left;"><a class="btn btn-eventPR" href="profile.php"><span style="font-weight: bold; font-size: 14px; font-family: Arial sans-serif;">GO BACK TO PROFILE</span></a></div>
<h2 style="text-align:left;">E-Vent it</h2>

<div>
<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST" id="create-event" enctype="multipart/form-data">
<div id="807999966852778988-form-parent" class="wsite-form-container" style="margin-top:10px;">
  <ul class="formlist" id="807999966852778988-form-list">
    <div><div class="wsite-form-field" style="margin:5px 0px 5px 0px;">
  <label class="wsite-form-label" for="event-name">Event Name <span class="form-required">*</span></label>
  <div class="wsite-form-input-container">
    <input id="event-name" class="wsite-form-input wsite-input" type="text" name="event-name" style="width:200px;" />
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
              <select name='type' class='form-select'>
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
	<option value='Alternative'>Alternative</option>
	<option value='Rock'>Rock</option>
    <option value='Pop'>Pop</option>
    <option value='Rap'>Hip Hop / Rap</option>
    <option value='Electronic'>Electronic</option>
    <option value='Country'>Country</option>
    <option value='Classical'>Classical</option>
</select>

  </div>
  <div id="instructions-Select a Genre:" class="wsite-form-instructions" style="display:none;"></div>
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
  <label class="wsite-form-label" for="description">Brief Description <span class="form-required">*</span></label>
  <div class="wsite-form-input-container">
    <textarea id="description" class="wsite-form-input wsite-input" name="description" style="width:285px; height: 50px"></textarea>
  </div>
  <div id="instructions-740288841696996782" class="wsite-form-instructions" style="display:none;"></div>
</div></div>
  </ul>
</div>
<div style="text-align:left; margin-top:10px; margin-bottom:10px;">
  <input type='submit' name="submit" value="Submit" class='btn btn-eventPR' />
</div>


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

  <label class="wsite-form-label" for="photo">Upload File <span class="form-required">*</span></label>
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