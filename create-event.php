<?php
error_reporting(-1);
$iphone = strpos($_SERVER['HTTP_USER_AGENT'],"iPhone");
$android = strpos($_SERVER['HTTP_USER_AGENT'],"Android");
$palmpre = strpos($_SERVER['HTTP_USER_AGENT'],"webOS");
$berry = strpos($_SERVER['HTTP_USER_AGENT'],"BlackBerry");
$ipod = strpos($_SERVER['HTTP_USER_AGENT'],"iPod");

// if ($iphone || $android || $palmpre || $ipod || $berry == true)
// {
// header('Location: http://icom5016.ece.uprm.edu/~g13/mobile-index.html');
// //OR
// }

// else {
//         header('Location: http://icom5016.ece.uprm.edu/~g13/home.html');

// }

require_once('db.php');

$db = db::getInstance();
$sql = "SELECT * FROM Event";
$stmt = $db->prepare($sql);
// $stmt->bindParam(':table', $table, PDO::PARAM_STR);
$stmt->execute();
// var_dump($stmt->fetchColumn(0));
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
    <script type='text/javascript'><!--
    var STATIC_BASE = 'http://cdn1.editmysite.com/';
    var STYLE_PREFIX = 'wsite';
    //-->
    </script>
    <script type='text/javascript' src='https://ajax.googleapis.com/ajax/libs/jquery/1.8.1/jquery.min.js'></script>
    <script type='text/javascript' src='http://cdn1.editmysite.com/editor/libraries/jquery_effects.js?1346362758'></script>
    <script type='text/javascript' src='http://cdn1.editmysite.com/editor/libraries/fancybox/fancybox.min.js?1346362758'></script>
    <script type='text/javascript' src='http://cdn1.editmysite.com/editor/images/common/utilities-jq.js?1346362758'></script>
    <script type='text/javascript' src='http://cdn1.editmysite.com/editor/libraries/flyout_menus_jq.js?1346362758'></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="http://code.jquery.com/jquery-latest.js"></script>
    <script type='text/javascript'><!--
var IS_ARCHIVE=1;
(function(jQuery){
function initFlyouts(){initPublishedFlyoutMenus([{"id":"581818271480209023","title":"Home","url":"index.html"},{"id":"145650631833651339","title":"Concerts","url":"concerts.html"},{"id":"404778243583026952","title":"Sports","url":"sports.html"},{"id":"441792526610757515","title":"Entertainment","url":"entertainment.html"},{"id":"269210016325162137","title":"Business & Education","url":"business--education.html"},{"id":"224132398954985812","title":"Profile","url":"profile.html"},{"id":"313146698326919915","title":"Login","url":"login.html"},{"id":"435700788219059228","title":"Nightwish Detail","url":"nightwish-detail.html"},{"id":"549951918166142509","title":"Add Friends","url":"add-friends.html"},{"id":"170216070745516754","title":"Venue","url":"venue.html"}],'115402879236912927',"<li class='wsite-nav-more'><a href='#'>more...<\/a><\/li>",'',false)}
if (jQuery) {
if (jQuery.browser.msie) window.onload = initFlyouts;
else jQuery(initFlyouts)
}else{
if (Prototype.Browser.IE) window.onload = initFlyouts;
else document.observe('dom:loaded', initFlyouts);
}
})(window._W && _W.jQuery)
//-->
</script>
</head>
<body class='wsite-theme-dark no-header-page wsite-page-create-event'>
<div id="wrapper">
	<table id="header">
		<tr>
			<td id="logo"><span class='wsite-logo'><a href=''><span id="wsite-title">E-venturePR</span></a></span></td>
			<td id="header-right">
				<table>
					<tr>
                        <td class="phone-number"><span class='wsite-text'><a href="profile3.html" style="color: #32CD32; text-decoration: underline; ">Profile</a> | <a href="home.html" style="color: #32CD32; text-decoration: underline;">Log out</a></span></td>
                        <td class="social"></td>
                    </tr>
				</table>
				<div class="search"></div>
			</td>
		</tr>
	</table>
	<div id="navigation">
        <ul><li id='active'><a href='home2.html'>Home</a></li><li id='pg145650631833651339'><a href='concerts2.html'>Music</a></li><li id='pg404778243583026952'><a href='sports2.html'>Sports</a></li><li id='pg441792526610757515'><a href='entertainment2.html'>Entertainment</a></li><li id='pg269210016325162137'><a href='business--education2.html'>Business & Education</a></li><li id="pgabout_us"><a href="about-us2.html">About Us</a></li></ul>
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
    <div style="text-align: left;"><a class="btn btn-eventPR" href="profile3.html"><span style="font-weight: bold; font-size: 14px; font-family: Arial sans-serif;">GO BACK TO PROFILE</span></a></div>
<h2 style="text-align:left;">E-Vent it</h2>

<div>
<form enctype="multipart/form-data" action="http://www.weebly.com/weebly/apps/formSubmit.php" method="POST" id="form-807999966852778988">
<div id="807999966852778988-form-parent" class="wsite-form-container" style="margin-top:10px;">
  <ul class="formlist" id="807999966852778988-form-list">
    <div><div class="wsite-form-field" style="margin:5px 0px 5px 0px;">
  <label class="wsite-form-label" for="input-461209313855761342">Event Name <span class="form-required">*</span></label>
  <div class="wsite-form-input-container">
    <input id="input-461209313855761342" class="wsite-form-input wsite-input" type="text" name="_u461209313855761342" style="width:200px;" />
  </div>
  <div id="instructions-461209313855761342" class="wsite-form-instructions" style="display:none;"></div>
</div></div>

<div><div class="wsite-form-field" style="margin:5px 0px 5px 0px;">
  <label class="wsite-form-label" for="input-376105289394483033">Date <span class="form-required">*</span></label>
  <div class="wsite-form-input-container">
    <input id="input-376105289394483033" class="wsite-form-input wsite-input" type="text" name="_u376105289394483033" style="width:200px;" />
  </div>
  <div id="instructions-376105289394483033" class="wsite-form-instructions" style="display:none;"></div>
</div></div>

<div><div class="wsite-form-field" style="margin:5px 0px 5px 0px;">
  <label class="wsite-form-label" for="input-935462346745001510">Location <span class="form-required">*</span></label>
  <div class="wsite-form-input-container">
    <input id="input-935462346745001510" class="wsite-form-input wsite-input" type="text" name="_u935462346745001510" style="width:200px;" />
  </div>
  <div id="instructions-935462346745001510" class="wsite-form-instructions" style="display:none;"></div>
</div></div>

      <div><div class="wsite-form-field" style="margin:5px 0px 0px 0px;">
          <label class="wsite-form-label" for="input-860164904846382269">Select a Type: <span class="form-required">*</span></label>
          <div class="wsite-form-radio-container">
              <select name='_u860164904846382269' class='form-select'>
                  <option value='Concert'>Concert</option>
                  <option value='Sports'>Sports</option>
                  <option value='Sports'>Entertainment</option>
                  <option value='Business &amp; Education'>Business &amp; Education</option>
              </select>

          </div>
          <div id="instructions-Select a Genre:" class="wsite-form-instructions" style="display:none;"></div>
      </div></div>

<div><div class="wsite-form-field" style="margin:5px 0px 0px 0px;">
  <label class="wsite-form-label" for="input-860164904846382269">Select a Genre: <span class="form-required">*</span></label>
  <div class="wsite-form-radio-container">
    <select name='_u860164904846382269' class='form-select'>
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
          <label class="wsite-form-label" for="input-860164904846382269">Public or Private? <span class="form-required">*</span></label>
          <div class="wsite-form-radio-container">
              <select name='_u860164904846382269' class='form-select'>
                  <option value='Public'>Public</option>
                  <option value='Private'>Private</option>
              </select>

          </div>
          <div id="instructions-Select a Genre:" class="wsite-form-instructions" style="display:none;"></div>
      </div></div>

<div><div class="wsite-form-field" style="margin:5px 0px 5px 0px;">
  <label class="wsite-form-label" for="input-740288841696996782">Brief Description <span class="form-required">*</span></label>
  <div class="wsite-form-input-container">
    <textarea id="input-740288841696996782" class="wsite-form-input wsite-input" name="_u740288841696996782" style="width:285px; height: 50px"></textarea>
  </div>
  <div id="instructions-740288841696996782" class="wsite-form-instructions" style="display:none;"></div>
</div></div>
  </ul>
</div>
<div style="display:none; visibility:hidden;">
  <input type="text" name="wsite_subject" />
</div>
<div style="text-align:left; margin-top:10px; margin-bottom:10px;">
  <input type="hidden" name="form_version" value="2" />
  <input type="hidden" name="wsite_approved" id="wsite-approved" value="approved" />
  <input type="hidden" name="ucfid" value="807999966852778988" />
  <input type='submit' style='position:absolute;top:0;left:-9999px;width:1px;height:1px' /><a class='wsite-button' onclick="document.getElementById('form-807999966852778988').submit()"><span class='wsite-button-inner'>Submit</span></a>
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

    <a>
        <img src="uploads/1/3/4/4/13443306/1346212298.jpg" alt="Picture" style="width:auto;max-width:100%; margin-top: 100px;" />
    </a>
<div><div class="wsite-form-field" style="margin:5px 0px 5px 0px;">

  <label class="wsite-form-label" for="input-436611527555598588">Upload File <span class="form-required">*</span></label>
  <div class="wsite-form-input-container">
    <input type="hidden" name="MAX_FILE_SIZE" value="20971520" />
    <input id="input-436611527555598588" class="wsite-form-input" type="file" name="_u436611527555598588" />
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